<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\BaoCaoDoanhThu;
use App\Models\ChiTietPhieuNhap;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class TonKhoController extends Controller
{
    public function lietKe(){

        $dataTK = DB::table('tbl_sanpham')
                ->orderByDesc('tbl_sanpham.SoLuongTrongKho')
                ->paginate(10);

        $dataDM = DB::table('tbl_sanpham')
                ->join('tbl_danhmuc', 'tbl_danhmuc.MaDanhMuc', '=', 'tbl_sanpham.MaDanhMuc')
                ->select('tbl_danhmuc.MaDanhMuc', 'tbl_danhmuc.TenDanhMuc', 
                DB::raw('SUM(tbl_sanpham.SoLuongTrongKho) as tongSLTK'))
                ->groupBy('tbl_danhmuc.MaDanhMuc')
                ->orderByDesc('tongSLTK');

        $labels = $dataDM ->pluck('TenDanhMuc');
        
        $data = $dataDM ->pluck('tongSLTK');
//        dd($data);
//        dd($labels);
        return view('admin.TonKho.lietKeTK', compact('data', 'labels', 'dataTK' ));
    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = BaoCaoDoanhThu::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();
        foreach($get as $key => $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        
        $dauThangNay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $BaThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(3)->startOfMonth()->toDateString();
        $cuoiThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value'] == '7ngay'){
            $get = BaoCaoDoanhThu::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == 'thangtruoc'){
            $get = BaoCaoDoanhThu::whereBetween('order_date', [$dauThangTruoc, $cuoiThangTruoc])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == 'thangnay'){
            $get = BaoCaoDoanhThu::whereBetween('order_date', [$dauThangNay, $now])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == '365ngayqua'){
            $get = BaoCaoDoanhThu::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == '3thangtruoc'){
            $get = BaoCaoDoanhThu::whereBetween('order_date', [$BaThangTruoc, $now])->orderBy('order_date', 'ASC')->get();
        }

        foreach($get as $key => $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function days_order(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = BaoCaoDoanhThu::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'ASC')->get();
        foreach($get as $key => $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function TrangLietKeBCDT(){
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $allDonHang = DonHang::where('TrangThai', 3)->whereBetween('ThoiGianTao', ['2024-06-01', $now])->get();
        $chart_data = [];
        foreach($allDonHang as $key => $donHang){
            $allChiTietDonHang = ChiTietDonHang::orderby('MaCTDH', 'DESC')->where('order_code', $donHang['order_code'])->get();
            foreach($allChiTietDonHang as $key => $ctdh){
                $chart_data[] = array(
                    'MaSanPham' => $ctdh->MaSanPham,
                    'SoLuong' => $ctdh->SoLuong,
                    'GiaSanPham' => $ctdh->GiaSanPham,
                );
            }
        }
        
        for($i = 0; $i < count($chart_data); $i++){
            for($j = $i + 1; $j < count($chart_data); $j++){
                if( $chart_data[$i]['MaSanPham'] == $chart_data[$j]['MaSanPham']){
                    $chart_data[$i]['SoLuong'] += $chart_data[$j]['SoLuong'];
                }
            }
        }
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
        $chart_data = collect($chart_data)->unique('MaSanPham')->toArray();
        $allChiTietPhieuNhap = ChiTietPhieuNhap::orderBy('MaSanPham', 'DESC')->get();

        return view('admin.BaoCaoDoanhThu.TrangLietKeBCDT')->with(compact('chart_data', 'allSanPham', 'allChiTietPhieuNhap'));
    }

    public function BaoCaoDoanhThuTheoDate(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $dauThangNay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $BaThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(3)->startOfMonth()->toDateString();
        $cuoiThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        if($data['TrangThaiBaoCao']){
            if($data['TrangThaiBaoCao'] == '7ngay'){
                $allDonHang = DonHang::whereBetween('ThoiGianTao', [$sub7days, $now])->get();
            }elseif($data['TrangThaiBaoCao'] == 'thangtruoc'){
                $allDonHang = DonHang::whereBetween('ThoiGianTao', [$dauThangTruoc, $cuoiThangTruoc])->get();
            }elseif($data['TrangThaiBaoCao'] == 'thangnay'){
                $allDonHang = DonHang::whereBetween('ThoiGianTao', [$dauThangNay, $now])->get();
            }elseif($data['TrangThaiBaoCao'] == '365ngayqua'){
                $allDonHang = DonHang::whereBetween('ThoiGianTao', [$sub365days, $now])->get();
            }elseif($data['TrangThaiBaoCao'] == '3thangtruoc'){
                $allDonHang = DonHang::whereBetween('ThoiGianTao', [$BaThangTruoc, $now])->get();
            }

            $chart_data = [];
            foreach($allDonHang as $key => $donHang){
                $allChiTietDonHang = ChiTietDonHang::orderby('MaCTDH', 'DESC')->where('order_code', $donHang['order_code'])->get();
                foreach($allChiTietDonHang as $key => $ctdh){
                    $chart_data[] = array(
                        'MaSanPham' => $ctdh->MaSanPham,
                        'SoLuong' => $ctdh->SoLuong,
                        'GiaSanPham' => $ctdh->GiaSanPham,
                    );
                }
            }
            
            for($i = 0; $i < count($chart_data); $i++){
                for($j = $i + 1; $j < count($chart_data); $j++){
                    if( $chart_data[$i]['MaSanPham'] == $chart_data[$j]['MaSanPham']){
                        $chart_data[$i]['SoLuong'] += $chart_data[$j]['SoLuong'];
                    }
                }
            }
            $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
            $chart_data = collect($chart_data)->unique('MaSanPham')->toArray();
            $allChiTietPhieuNhap = ChiTietPhieuNhap::orderBy('MaSanPham', 'DESC')->get();

            $this->xuatFileBCDT($request, $from_date, $to_date, $chart_data);
    
            //return view('admin.BaoCaoDoanhThu.TrangLietKeBCDT')->with(compact('chart_data', 'allSanPham', 'allChiTietPhieuNhap'));
        }elseif(Empty($data['TrangThaiBaoCao'])){
            $allDonHang = DonHang::where('TrangThai', 3)->whereBetween('ThoiGianTao', [$from_date, $to_date])->get();
            $chart_data = [];
            foreach($allDonHang as $key => $donHang){
                $allChiTietDonHang = ChiTietDonHang::orderby('MaCTDH', 'DESC')->where('order_code', $donHang['order_code'])->get();
                foreach($allChiTietDonHang as $key => $ctdh){
                    $chart_data[] = array(
                        'MaSanPham' => $ctdh->MaSanPham,
                        'SoLuong' => $ctdh->SoLuong,
                        'GiaSanPham' => $ctdh->GiaSanPham,
                    );
                }
            }
            
            for($i = 0; $i < count($chart_data); $i++){
                for($j = $i + 1; $j < count($chart_data); $j++){
                    if( $chart_data[$i]['MaSanPham'] == $chart_data[$j]['MaSanPham']){
                        $chart_data[$i]['SoLuong'] += $chart_data[$j]['SoLuong'];
                    }
                }
            }
            $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
            $chart_data = collect($chart_data)->unique('MaSanPham')->toArray();
            $allChiTietPhieuNhap = ChiTietPhieuNhap::orderBy('MaSanPham', 'DESC')->get();
    
            return view('admin.BaoCaoDoanhThu.TrangLietKeBCDT')->with(compact('chart_data', 'allSanPham', 'allChiTietPhieuNhap'));
        }
    }

    public function xuatFileBCDT(Request $request, $from_date, $to_date, $chart_data){
        //$allDonHang = DonHang::where('TrangThai', 3)->whereBetween('ThoiGianTao', [$from_date, $to_date])->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'BÁO CÁO DOANH THU');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
            'bold' => true,
            'color' => ['rgb' => '0E46A3'],
            'name' => 'Times New Roman',
            'size' => 18,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        ]);

        $sheet->setCellValue('A2', 'Ngày lập: ' . date('d/m/Y'));
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => [
            'bold' => true,
            'italic' => true,
            'color' => ['rgb' => '0E46A3'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        ]);

        $sheet->setCellValue('I4', 'TỔNG CỘNG');
        $sheet->mergeCells('I4:K4');
        $sheet->getStyle('I4:K4')->applyFromArray([
            'font' => [
            'bold' => true,
            'color' => ['rgb' => '0E46A3'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFFFF'],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
        ]);

        $sheet->getRowDimension(4)->setRowHeight(30);
        $sheet->getRowDimension(5)->setRowHeight(30);
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20); 
        $sheet->getColumnDimension('F')->setWidth(15); 
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20); 

        
        $sheet->setCellValue('A5', 'Ngày')
              ->setCellValue('B5', 'Số tiền')
              ->setCellValue('C5', 'Theo kế hoạch')
              ->setCellValue('D5', 'Chi phí')
              ->setCellValue('E5', 'Doanh thu')
              ->setCellValue('F5', 'Tháng')
              ->setCellValue('G5', 'Quý')
              ->setCellValue('H5', 'Năm')
              ->setCellValue('I5', 'Tháng')
              ->setCellValue('J5', 'Quý')
              ->setCellValue('K5', 'Năm');

        $sheet->getStyle('A5:K5')->applyFromArray([
            'font' => [
            'bold' => true,
            'color' => ['rgb' => '0E46A3'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'BFF6C3'],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
        ]);
        

        $tongTienThang = BaoCaoDoanhThu::selectRaw('YEAR(order_date) as nam, MONTH(order_date) as thang, SUM(sales) as tongTien')
                                        ->groupBy('nam', 'thang')
                                        ->orderBy('nam', 'ASC')
                                        ->orderBy('thang', 'ASC')
                                        ->get();
        $tongTienQuy = BaoCaoDoanhThu::selectRaw('YEAR(order_date) as nam, QUARTER(order_date) as quy, SUM(sales) as tongTien')
                                        ->groupBy('nam', 'quy')
                                        ->orderBy('nam', 'ASC')
                                        ->orderBy('quy', 'ASC')
                                        ->get();
        $tongTienNam = BaoCaoDoanhThu::selectRaw('YEAR(order_date) as nam, SUM(sales) as tongTien')
                                        ->groupBy('nam')
                                        ->orderBy('nam', 'ASC')
                                        ->get();
        $row = 6;
        foreach ($chart_date as $item) {
            $ngay = date_format(date_create($item->order_date), 'd/m/Y');
            $thang = date_format(date_create($item->order_date), 'm');
            $nam = date_format(date_create($item->order_date), 'Y');
            if($thang == 1 || $thang == 2 || $thang == 3){
                $quy = 1;
            }elseif($thang == 4 || $thang == 5 || $thang == 6){
                $quy = 2;
            }elseif($thang == 7 || $thang == 8 || $thang == 9){
                $quy = 3;
            }else $quy = 4;
            $chiphi = $item->sales - $item->profit;
            foreach($tongTienThang as $i){
                if($i->thang == $thang){
                    $doanhThuThang = $i->tongTien;
                    break;
                }
            }
            foreach($tongTienQuy as $i){
                if($i->quy == $quy){
                    $doanhThuQuy = $i->tongTien;
                    break;
                }
            }
            foreach($tongTienNam as $i){
                if($i->nam == $nam){
                    $doanhThuNam = $i->tongTien;
                    break;
                }
            }
            $sheet->setCellValue('A' . $row, $ngay)
                  ->setCellValue('B' . $row, $item->sales)
                //   ->setCellValue('C' . $row, $item->sales)
                  ->setCellValue('D' . $row, $chiphi)
                  ->setCellValue('E' . $row, $item->profit)
                  ->setCellValue('F' . $row, 'Tháng ' . $thang)
                  ->setCellValue('G' . $row, 'Quý ' . $quy)
                  ->setCellValue('H' . $row, 'Năm ' . $nam)
                  ->setCellValue('I' . $row, $doanhThuThang)
                  ->setCellValue('J' . $row, $doanhThuQuy)
                  ->setCellValue('K' . $row, $doanhThuNam);
            $row++;
        }
        $sheet->getStyle('A6:K' . ($row - 1))->applyFromArray([
            'font' => [
            'color' => ['rgb' => '000000'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        ]);
        $sheet->getStyle('B6:K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        

        $sheet->setCellValue('C' . ($row + 3), 'Nguời lập biểu');
        $sheet->setCellValue('F' . ($row + 3), 'Kế toán trưởng');
        $sheet->setCellValue('I' . ($row + 3), 'Giám đốc');
        $sheet->mergeCells('C'.($row + 3) . ':D' . ($row + 3));
        $sheet->mergeCells('F'.($row + 3) . ':G' . ($row + 3));
        $sheet->mergeCells('I'.($row + 3) . ':J' . ($row + 3));
        $sheet->getStyle('A' . ($row + 3) . ':K' . ($row + 3))->applyFromArray([
            'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        ]);
        
        $sheet->setCellValue('C' . ($row + 4), '(Ký và ghi rõ họ tên)');
        $sheet->setCellValue('F' . ($row + 4), '(Ký và ghi rõ họ tên)');
        $sheet->setCellValue('I' . ($row + 4), '(Ký và ghi rõ họ tên)');
        $sheet->mergeCells('C'.($row + 4) . ':D' . ($row + 4));
        $sheet->mergeCells('F'.($row + 4) . ':G' . ($row + 4));
        $sheet->mergeCells('I'.($row + 4) . ':J' . ($row + 4));
        $sheet->getStyle('A' . ($row + 4) . ':K' . ($row + 4))->applyFromArray([
            'font' => [
            'color' => ['rgb' => '000000'],
            'name' => 'Times New Roman',
            'size' => 13,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        ]);

        $tg = date('Y_m_d');
        $fileName = $tg . '.xlsx';
        $filePath = public_path('baoCaoDoanhThu/' . $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        return response()->download($filePath, $fileName);
    }

}
