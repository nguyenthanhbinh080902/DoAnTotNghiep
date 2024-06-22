<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuNhap;
use App\Models\NhaCungCap;
use App\Models\PhieuTraHang;
use App\Models\PhieuXuat;
use App\Models\SanPham;
use Exception;
use Session;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use App\Models\PhieuNhap;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;



class PhieuNhapController extends Controller
{
    public function trangXemPhieuNhap(){
        $pns = DB::table('tbl_phieunhap')
                ->join('tbl_taikhoan', 'tbl_phieunhap.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
                ->join('tbl_nhacungcap', 'tbl_phieunhap.MaNhaCungCap', '=', 'tbl_nhacungcap.MaNhaCungCap')
                ->leftJoin('tbl_chitietphieunhap', 'tbl_phieunhap.MaPhieuNhap', '=', 'tbl_chitietphieunhap.MaPhieuNhap')
                ->select('tbl_phieunhap.*', 'tbl_taikhoan.TenTaiKhoan', 'tbl_nhacungcap.TenNhaCungCap',
                        DB::raw('COUNT(tbl_chitietphieunhap.MaCTPN) as soChiTietPN'))
                ->groupBy('tbl_phieunhap.MaPhieuNhap')
                ->orderByDesc('tbl_phieunhap.ThoiGianTao')
                ->paginate(5);

        return view('admin.PhieuNhap.lietKePN', ['data' => $pns]);
    } 

    public function timKiemPN(Request $request){

        $data = PhieuNhap::join('tbl_taikhoan', 'tbl_phieunhap.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
            ->join('tbl_nhacungcap', 'tbl_phieunhap.MaNhaCungCap', '=', 'tbl_nhacungcap.MaNhaCungCap')
            ->leftJoin('tbl_chitietphieunhap', 'tbl_phieunhap.MaPhieuNhap', '=', 'tbl_chitietphieunhap.MaPhieuNhap')
            ->select('tbl_phieunhap.*', 'tbl_taikhoan.TenTaiKhoan', 'tbl_nhacungcap.TenNhaCungCap',
                        DB::raw('COUNT(tbl_chitietphieunhap.MaCTPN) as soChiTietPN'))
            ->where(function($query) use ($request) {
                $query->where('tbl_taikhoan.TenTaiKhoan', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere('tbl_nhacungcap.TenNhaCungCap', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere(DB::raw("DATE_FORMAT(tbl_phieunhap.ThoiGianTao, '%Y-%m')"), '=', "{$request->thoiGian}");
            })
            ->groupBy('tbl_phieunhap.MaPhieuNhap')
            ->paginate(5);
        return view('admin.PhieuNhap.lietKePN', compact('data'));
    }

    public function locPN(Request $request){

        $data = PhieuNhap::join('tbl_taikhoan', 'tbl_phieunhap.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
            ->join('tbl_nhacungcap', 'tbl_phieunhap.MaNhaCungCap', '=', 'tbl_nhacungcap.MaNhaCungCap')
            ->leftJoin('tbl_chitietphieunhap', 'tbl_phieunhap.MaPhieuNhap', '=', 'tbl_chitietphieunhap.MaPhieuNhap')
            ->select('tbl_phieunhap.*', 'tbl_taikhoan.TenTaiKhoan', 'tbl_nhacungcap.TenNhaCungCap',
                        DB::raw('COUNT(tbl_chitietphieunhap.MaCTPN) as soChiTietPN'))
            ->where(DB::raw("DATE_FORMAT(tbl_phieunhap.ThoiGianTao, '%Y-%m')"), '=', "{$request->thoiGian}")
            ->groupBy('tbl_phieunhap.MaPhieuNhap')
            ->paginate(5);
        return view('admin.PhieuNhap.lietKePN', compact('data'));
    }
    public function xemCTPN($id){
        $pn = DB::select("SELECT pn.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                        FROM tbl_phieunhap pn 
                        JOIN tbl_taikhoan tk ON pn.MaTaiKhoan = tk.MaTaiKhoan
                        JOIN tbl_nhacungcap ncc ON pn.MaNhaCungCap = ncc.MaNhaCungCap
                        WHERE MaPhieuNhap = ?", [$id]);
        $ctpn = DB::select("SELECT ct.*, sp.TenSanPham
                        FROM tbl_chitietphieunhap ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuNhap = ?", [$id]);
        $pth = DB::select("SELECT pth.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                        FROM tbl_phieutrahang pth 
                        JOIN tbl_taikhoan tk ON pth.MaTaiKhoan = tk.MaTaiKhoan
                        JOIN tbl_nhacungcap ncc ON pth.MaNhaCungCap = ncc.MaNhaCungCap
                        WHERE MaPhieuNhap = ?", [$id]);
        if(!empty($pth)){
            $maPTH = $pth[0]->MaPhieuTraHang;
        
            $ctth = DB::select("SELECT ct.*, sp.TenSanPham
                            FROM tbl_chitietphieutrahang ct
                            JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                            WHERE MaPhieuTraHang = ?", [$maPTH]);
            $pthKQ = $pth[0];
        }else { 
            $ctth = null;
            $pthKQ = null;
        }
        
        return view('admin.PhieuNhap.xemcT', ['pn' => $pn[0], 'ctpn' => $ctpn, 'pth' => $pthKQ, 'ctth' => $ctth]);
    }

    public function xuatFilePN($id){
        $pn = DB::select("SELECT pn.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                FROM tbl_phieunhap pn 
                JOIN tbl_taikhoan tk ON pn.MaTaiKhoan = tk.MaTaiKhoan
                JOIN tbl_nhacungcap ncc ON pn.MaNhaCungCap = ncc.MaNhaCungCap
                WHERE MaPhieuNhap = ? ", [$id]);
        $ctpn = DB::select("SELECT ct.*, sp.TenSanPham
                FROM tbl_chitietphieunhap ct
                JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                WHERE MaPhieuNhap = ? ", [$id]);
        $pth = DB::select("SELECT pth.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                FROM tbl_phieutrahang pth 
                JOIN tbl_taikhoan tk ON pth.MaTaiKhoan = tk.MaTaiKhoan
                JOIN tbl_nhacungcap ncc ON pth.MaNhaCungCap = ncc.MaNhaCungCap
                WHERE MaPhieuNhap = ? AND pth.TrangThai = 1 ", [$id]);
        if(!empty($pth)){
            $maPTH = $pth[0]->MaPhieuTraHang;
            $ctth = DB::select("SELECT ct.*, sp.TenSanPham
                        FROM tbl_chitietphieutrahang ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuTraHang = ? ", [$maPTH]);
        }
        
        $tg1 = date_format(date_create($pn[0]->ThoiGianTao), 'd/m/Y');
        // $tg2 = date_format(date_create($pn[0]->ThoiGianSua), 'd/m/Y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B1', 'PHIẾU NHẬP');
        $sheet->getStyle('B1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20,
            ],
        ]);
        

        $sheet->setCellValue('A3', 'Mã phiếu nhập:');
        $sheet->setCellValue('B3', $id);
        $sheet->setCellValue('C3', 'Thời gian:');
        $sheet->setCellValue('D3', $tg1);
        $sheet->setCellValue('A4', 'Người lập:');
        $sheet->setCellValue('B4', $pn[0]->TenTaiKhoan);
        $sheet->setCellValue('C4', 'Tên nhà cung cấp:');
        $sheet->setCellValue('D4', $pn[0]->TenNhaCungCap);
        if($pn[0]->TrangThai){
            $trangThai = 'Đã xác nhận';
        }else{
            $trangThai = 'Chưa xác nhận';
        }
        if($pn[0]->PhuongThucThanhToan == 0){
            $thanhToan = 'Chuyển khoản';
        }elseif($pn[0]->PhuongThucThanhToan == 1){
            $thanhToan = 'Tiền mặt';
        }else{
            $thanhToan = 'Khác';
        }
        $sheet->setCellValue('A5', 'Trạng thái:');
        $sheet->setCellValue('B5', $trangThai);
        $sheet->setCellValue('C5', 'Phương thức thanh toán:');
        $sheet->setCellValue('D5', $thanhToan);

        foreach(range('A', 'F') as $i){
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }

        $sheet->setCellValue('A7', 'Mã sản phẩm')
              ->setCellValue('B7', 'Tên sản phẩm')
              ->setCellValue('C7', 'Số lượng')
              ->setCellValue('D7', 'Giá nhập')
              ->setCellValue('E7', 'Thành tiền');
        $row = 8;
        foreach ($ctpn as $item) {
            $thanhTien = $item->SoLuong * $item->GiaSanPham;
            $sheet->setCellValue('A' . $row, $item->MaSanPham)
                  ->setCellValue('B' . $row, $item->TenSanPham)
                  ->setCellValue('C' . $row, $item->SoLuong)
                  ->setCellValue('D' . $row, $item->GiaSanPham)
                  ->setCellValue('E' . $row, $thanhTien);
            $row++;
        }

        $sheet->setCellValue('A' . ($row), 'Tổng tiền nhập hàng');
        $sheet->setCellValue('E' . ($row), $pn[0]->TongTien);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_YELLOW]
            ]
        ]);

        $sheet->setCellValue('A' . ($row + 1), 'Số tiền trả');
        $sheet->setCellValue('E' . ($row + 1), $pn[0]->TienTra);
        $sheet->getStyle('A' . ($row + 1) . ':E' . ($row + 1))->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_GREEN]
            ]
        ]);

        

        $sheet->getStyle('A7:E' . ($row))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => Color::COLOR_BLACK],
                ],
            ],
        ]);

        $tongTienTraHang = 0;
        if(!empty($ctth)){
            $n = $row + 3;
            $sheet->setCellValue('B'. $n, 'DANH SÁCH SẢN PHẨM TRẢ HÀNG');
            $sheet->getStyle('B' .$n)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
            ]);
            $n++;
            $sheet->setCellValue('A' . $n, 'Mã sản phẩm')
              ->setCellValue('B' . $n, 'Tên sản phẩm')
              ->setCellValue('C' . $n, 'Số lượng')
              ->setCellValue('D' . $n, 'Giá nhập')
              ->setCellValue('E' . $n, 'Lý do trả hàng');
            $row = $n + 1;
            foreach ($ctth as $j) {
                $sheet->setCellValue('A' . $row, $j->MaSanPham)
                    ->setCellValue('B' . $row, $j->TenSanPham)
                    ->setCellValue('C' . $row, $j->SoLuong)
                    ->setCellValue('D' . $row, $j->GiaSanPham)
                    ->setCellValue('E' . $row, $j->LyDoTraHang);
                $row++;
            }

            $sheet->setCellValue('A' . ($row), 'Tổng tiền trả hàng');
            $sheet->setCellValue('E' . ($row), $pth[0]->TongTien);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => Color::COLOR_YELLOW]
                ]
            ]);
            $sheet->getStyle('A' . $n . ':E' . ($row))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ]);
            $tongTienTraHang = $pth[0]->TongTien;
            $row--;
        }
        $tienNo = $pn[0]->TongTien - $tongTienTraHang - $pn[0]->TienTra;
        $sheet->setCellValue('A' . ($row + 2), 'Số tiền nợ nhà cung cấp');
        $sheet->setCellValue('E' . ($row + 2), $tienNo);
        $sheet->getStyle('A' . ($row + 2). ':E' . ($row + 2))->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_RED]
            ]
        ]);
        
        $fileName = 'PhieuNhap_' . $id . '.xlsx';
        $filePath = public_path('phieuNhap/' . $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        return response()->download($filePath, $fileName);
    }

    public function suaPN($id){
        $pn = DB::select("SELECT pn.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                        FROM tbl_phieunhap pn 
                        JOIN tbl_taikhoan tk ON pn.MaTaiKhoan = tk.MaTaiKhoan
                        JOIN tbl_nhacungcap ncc ON pn.MaNhaCungCap = ncc.MaNhaCungCap
                        WHERE MaPhieuNhap = ?", [$id]);
        $products = SanPham::all();
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        $ctpn = DB::table('tbl_chitietphieunhap')
                ->join('tbl_sanpham', 'tbl_chitietphieunhap.MaSanPham', '=', 'tbl_sanpham.MaSanPham')
                ->select('tbl_chitietphieunhap.*', 'tbl_sanpham.TenSanPham')
                ->where('tbl_chitietphieunhap.MaPhieuNhap', [$id])
                ->paginate(5);

        return view('admin.PhieuNhap.suaPN', ['pn' => $pn[0], 'ctpn' => $ctpn, 'listLSP' => $listLSP], compact('products'));
    }

    public function lapPN(){
        $maPN = 'PN' . date('YmdHis');
        $listNCC = DB::select("SELECT MaNhaCungCap, TenNhaCungCap FROM tbl_nhacungcap WHERE TrangThai = 1");
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        $products = SanPham::all();
        return view('admin.PhieuNhap.themPN', ['listNCC' => $listNCC, 'maPN' => $maPN, 'listLSP' => $listLSP], compact('products'));
    }

    public function danhSachSanPham(Request $request)
    {
        $search = $request->input('q');
        $ids = $request->input('ids');
        $loaiSP = $request->input('loaiSP');

        if ($ids) {
            $products = SanPham::whereIn('MaSanPham', $ids)->get(['MaSanPham as id', 'TenSanPham as text']);
            return response()->json($products);
        }
        $query = SanPham::query();
        if($loaiSP){
            $query->where('MaDanhMuc', $loaiSP);
        }

        if($search){
            $query->where('TenSanPham', 'LIKE', "%{$search}%");
        }
        $products = $query->get(['MaSanPham as id', 'TenSanPham as text']);

        return response()->json($products);
    }
    
    public function xuLyLapPNCT1(Request $request){
        $maCTPN = 'CTPN' . uniqid();
        $maPN = $request->maPN;
        $maSP = $request->maSP;
        $soLuong = $request->soLuong;
        $gia = $request->gia;
        
        if ($maPN) {
            $ktSanPhamTonTai = ChiTietPhieuNhap::where('MaPhieuNhap', $maPN)
                                ->where('MaSanPham', $maSP)
                                ->first();
            if($ktSanPhamTonTai){
                $ktSanPhamTonTai->SoLuong += $soLuong;
                $ktSanPhamTonTai->GiaSanPham = $gia;
                $ktSanPhamTonTai->save();
                $message = 'Cập nhật thành công';
            }else{
                $ctpn = new ChiTietPhieuNhap();
                $ctpn->MaCTPN = $maCTPN;
                $ctpn->MaPhieuNhap = $maPN;
                $ctpn->MaSanPham = $maSP;
                $ctpn->SoLuong = $soLuong;
                $ctpn->GiaSanPham = $gia;      
                $ctpn->save();
                $message = 'Thêm thành công';
            }
            $tenSP = DB::select("SELECT TenSanPham FROM tbl_sanpham WHERE MaSanPham = ? ", [$maSP]);
            $tenSP1 = $tenSP[0]->TenSanPham;
            return response()->json([
                'success' => true,
                'message' =>$message,
                'maCTPN' => $maCTPN,
                'maPN' => $maPN,
                'maSP' => $maSP,
                'tenSP' => $tenSP1,
                'soLuong' => $ktSanPhamTonTai ? $ktSanPhamTonTai->SoLuong : $soLuong,
                'gia' => $gia,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        
    }

    public function xuLyLapPNCT(Request $request){
        $messages = [
            'maSP.required' => 'vui lòng chọn sản phẩm',
            'soLuong.required' => 'vui lòng nhập số lượng',
            'gia.required' => 'Vui lòng nhập giá nhập',
        ];
        $valid = $request->validate([
            'maSP' => 'required',
            'soLuong' => 'required',
            'gia' => 'required',
        ], $messages);

        $maCTPN = 'CTPN' . uniqid();
        $maPN = $request->maPNSua;
        $maSP = $request->maSP;
        $soLuong = $request->soLuong;
        $gia = $request->gia;
  
        $ktSanPhamTonTai = ChiTietPhieuNhap::where('MaPhieuNhap', $maPN)
                            ->where('MaSanPham', $maSP)
                            ->first();
        if($ktSanPhamTonTai){
            $ktSanPhamTonTai->SoLuong += $soLuong;
            $ktSanPhamTonTai->GiaSanPham = $gia;
            $ktSanPhamTonTai->save();
            $message = 'Cập nhật thành công';
        }else{
            $ctpn = new ChiTietPhieuNhap();
            $ctpn->MaCTPN = $maCTPN;
            $ctpn->MaPhieuNhap = $maPN;
            $ctpn->MaSanPham = $maSP;
            $ctpn->SoLuong = $soLuong;
            $ctpn->GiaSanPham = $gia;      
            $ctpn->save();
            $message = 'Thêm thành công';
        }
        return redirect()->route('suaPN', ['id'=>$maPN])->with('success', $message);
    }

    public function xoaCTS($id){
        $maPN = DB::select("SELECT MaPhieuNhap, MaSanPham, SoLuong FROM tbl_chitietphieunhap WHERE MaCTPN = ?", [$id]);
        DB::delete("DELETE FROM tbl_chitietphieunhap WHERE MaCTPN = ?", [$id]);
        return redirect()->route('suaPN', ['id' => $maPN[0]->MaPhieuNhap])->with('success', 'Xóa thành công');
    }

    public function xoaCTPN($id){
        DB::delete("DELETE FROM tbl_chitietphieunhap WHERE MaCTPN = ?", [$id]);  
        return redirect('/lap-phieu-nhap-chi-tiet');          
    }

    public function luuPN($id){
        $maPN = $id;
        $tongTien = 0;
        $ctpn = DB::select("SELECT * FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$maPN]);
        foreach ($ctpn as $ct){
            $tongTien += $ct->SoLuong * $ct->GiaSanPham;
        }

        $tienNo = $tongTien;
        PhieuNhap::where('MaPhieuNhap', $maPN)->update([
            'TongTien' => $tongTien,
            'TienNo' => $tienNo
        ]);

        return redirect('/liet-ke-phieu-nhap');
        
    }

    public function xuLyPN(Request $request)
    {
        $messages = [
            'maNCC.required' => 'Vui lòng nhập mã nhà cung cấp.',
        ];
        $valid = $request->validate([
            'maNCC' => 'required',
        ], $messages);

        if (!$valid) {
            return redirect()->back()->withInput();
        }
        
        $maPN = $request->maPhieu;
        $thoiGianTao = date('Y-m-d H:i:s');
        
        $tienTra = 0;
        $tienNo = $request->tongTien;
        $tenTK = $request->nguoiLap;
        $maTK = DB::select("SELECT * FROM tbl_taikhoan WHERE TenTaiKhoan = ?", [$tenTK]);
        $maNCC = $request->maNCC;
        $trangThai = 0;
        
        if ($maPN) {
            $phieunhap = new PhieuNhap();
            $phieunhap->MaPhieuNhap = $maPN;
            $phieunhap->MaNhaCungCap = $maNCC;
            $phieunhap->MaTaiKhoan = $maTK[0]->MaTaiKhoan;
            $phieunhap->PhuongThucThanhToan = $request->thanhToan;
            $phieunhap->TongTien = $request->tongTien;
            $phieunhap->TienTra = $tienTra;
            $phieunhap->TienNo = $tienNo;
            $phieunhap->TrangThai = $trangThai;
            $phieunhap->ThoiGianTao = $thoiGianTao;
            $phieunhap->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Mời bạn kiểm tra lại thông tin!!']);
    }

    public function updateSoLuong(Request $request)
    {
        $MaCTPN = $request->input('MaCTPN');
        $soLuong = $request->input('soLuong');
        $giaSanPham = $request->input('giaSanPham');
        
        if ($MaCTPN) {
            ChiTietPhieuNhap::where('MaCTPN', $MaCTPN)->update([
                'SoLuong' => $soLuong,
                'GiaSanPham' => $giaSanPham,
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    }

        
    public function xuLySuaPN(Request $request){
        $maPN = $request->maPN;
        $ctpn = DB::select("SELECT * FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$maPN]);
        $tongTien = 0;
        $tienTra = $request->tienTra;
        foreach ($ctpn as $ct){
            $tongTien += $ct->SoLuong * $ct->GiaSanPham;
        }
        $tienNo = $tongTien - $tienTra;
        $thoiGianSua = date('Y-m-d H:i:s');
        if($tienTra < 0){
            return redirect()->back()->withInput()->withErrors(['tienTra' => 'Số tiền chỉ nhập số dương']);
        }elseif($tienTra > $tongTien){
            return redirect()->back()->withInput()->withErrors(['tienTra' => 'Bạn nhập thừa tiền!!!']);
        }
        
        $trangThai1 = $request->trangThaiTruoc;
        $trangThai2 = $request->trangThai;
        $pth = DB::select("SELECT * FROM tbl_phieutrahang WHERE MaPhieuNhap = ?", [$maPN]);
        
        if($trangThai2 == 1 && ($trangThai1 != $trangThai2)){
            foreach($ctpn as $ct){
                $maSP = $ct->MaSanPham;
                $soLuong = $ct->SoLuong;
                $sltk = DB::select("SELECT SoLuongTrongKho, SoLuongHienTai FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
                $sl = $sltk[0]->SoLuongTrongKho + $soLuong;
                $sl2 = $sltk[0]->SoLuongHienTai + $soLuong;
                SanPham::where('MaSanPham', $maSP)->update([
                    'SoLuongTrongKho' => $sl,
                    'SoLuongHienTai' => $sl2,
                ]);
            }
        }elseif($trangThai2 == 0 && ($trangThai1 != $trangThai2)){
            if(!empty($pth)){
                $trangThaiPTH = $pth[0]->TrangThai;
                if($trangThaiPTH == 1){
                    return redirect()->back()->withErrors(['trangThai' => 'Đã tồn tại phiếu trả hàng được xác nhận. Mời bạn kiểm tra lại']);
                }
            }
            $spMoi = [];
            foreach($ctpn as $ct){
                $maSP = $ct->MaSanPham;
                $soLuong = $ct->SoLuong;

                $sltk = DB::select("SELECT SoLuongTrongKho, SoLuongHienTai FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
                $sltkHienTai = $sltk[0]->SoLuongTrongKho;
                $slhtHienTai = $sltk[0]->SoLuongHienTai;

                $sl = $sltkHienTai - $soLuong;
                $sl2 = $slhtHienTai - $soLuong;

                if($sl < 0){
                    return redirect()->back()->withErrors(['trangThai' => 'Số lượng trong kho không đủ. Mời bạn kiểm tra lại']);
                }

                $spMoi[$maSP] = [
                    'SoLuongTrongKho' => $sl,
                    'SoLuongHienTai' => $sl2,
                ];
            }
            foreach($spMoi as $maSP => $slMoi){
                SanPham::where('MaSanPham', $maSP)->update([
                    'SoLuongTrongKho' => $slMoi['SoLuongTrongKho'],
                    'SoLuongHienTai' => $slMoi['SoLuongHienTai'],
                ]);
            }
        }

        PhieuNhap::where('MaPhieuNhap', $maPN)->update([
            'TongTien' => $tongTien,
            'TienTra' => $tienTra,
            'TienNo' => $tienNo,
            'PhuongThucThanhToan' => $request->thanhToan,
            'TrangThai' => $request->trangThai,
            'ThoiGianSua' => $thoiGianSua,
        ]);
        return redirect()->route('xemPN');

    }

    public function xoaPN($id){
        $maPTH = DB::select("SELECT MaPhieuTraHang, TrangThai FROM tbl_phieutrahang WHERE MaPhieuNhap = ? ", [$id]);
        $pth = [];
        foreach($maPTH as $i){
            $tt = $i->TrangThai;
            $ma = $i->MaPhieuTraHang;
            if($tt == 1){
                return redirect('/liet-ke-phieu-nhap')->with(['error' => 'Mời bạn kiểm tra lại phiếu trả hàng (có phiếu đã được xác nhận)']);
            }
            
            $pth[] = $ma;
        }
        foreach($pth as $ma){
            DB::delete("DELETE FROM tbl_chitietphieutrahang WHERE MaPhieuTraHang = ?", [$ma]);
            DB::delete("DELETE FROM tbl_phieutrahang WHERE MaPhieuTraHang = ?", [$ma]);
        }
        
        DB::delete("DELETE FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$id]);
        DB::delete("DELETE FROM tbl_phieunhap WHERE MaPhieuNhap = ?", [$id]);

        return redirect('/liet-ke-phieu-nhap')->with('success', 'Xóa thành công!');
    }
}
