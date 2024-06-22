<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuXuat;
use App\Models\PhieuXuat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\SanPham;

class PhieuXuatController extends Controller
{
    //
    public function xem(){
        $pxs = DB::table('tbl_phieuxuat')
                ->join('tbl_taikhoan', 'tbl_phieuxuat.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
                ->leftJoin('tbl_chitietphieuxuat', 'tbl_phieuxuat.MaPhieuXuat', '=', 'tbl_chitietphieuxuat.MaPhieuXuat')
                ->select('tbl_phieuxuat.*', 'tbl_taikhoan.TenTaiKhoan',
                        DB::raw('COUNT(tbl_chitietphieuxuat.MaCTPX) as soCTPX'))
                ->groupBy('tbl_phieuxuat.MaPhieuXuat')
                ->orderByDesc('tbl_phieuxuat.ThoiGianTao')
                ->paginate(5);

        return view('admin.PhieuXuat.lietKe', ['data' => $pxs]);
    } 

    public function timKiemPX(Request $request){
        $data = PhieuXuat::join('tbl_taikhoan', 'tbl_phieuxuat.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
            ->leftJoin('tbl_chitietphieuxuat', 'tbl_phieuxuat.MaPhieuXuat', '=', 'tbl_chitietphieuxuat.MaPhieuXuat')
            ->select('tbl_phieuxuat.*', 'tbl_taikhoan.TenTaiKhoan',
                    DB::raw('COUNT(tbl_chitietphieuxuat.MaCTPX) as soCTPX'))
            ->where(function($query) use ($request) {
                $query->where('tbl_taikhoan.TenTaiKhoan', 'LIKE', "%{$request->timKiem}%")
                      ->orWhere('tbl_phieuxuat.TongSoLuong', 'LIKE', "%{$request->timKiem}%");
            })
            ->groupBy('tbl_phieuxuat.MaPhieuXuat')
            ->paginate(5);
        return view('admin.PhieuXuat.lietKe', compact('data'));
    }

    public function locPX(Request $request){

        $data = PhieuXuat::join('tbl_taikhoan', 'tbl_phieuxuat.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
            ->leftJoin('tbl_chitietphieuxuat', 'tbl_phieuxuat.MaPhieuXuat', '=', 'tbl_chitietphieuxuat.MaPhieuXuat')
            ->select('tbl_phieuxuat.*', 'tbl_taikhoan.TenTaiKhoan',
                    DB::raw('COUNT(tbl_chitietphieuxuat.MaCTPX) as soCTPX'))
            ->where(DB::raw("DATE_FORMAT(tbl_phieuxuat.ThoiGianTao, '%Y-%m')"), '=', "{$request->thoiGian}")
            ->groupBy('tbl_phieuxuat.MaPhieuXuat')
            ->paginate(5);
        return view('admin.PhieuXuat.lietKe', compact('data'));
    }

    public function xemCT($id){
        $px = DB::select("SELECT px.*, tk.TenTaiKhoan
                        FROM tbl_phieuxuat px 
                        JOIN tbl_taikhoan tk ON px.MaTaiKhoan = tk.MaTaiKhoan
                        WHERE MaPhieuXuat = ?", [$id]);
        $ct = DB::select("SELECT ct.*, sp.TenSanPham
                            FROM tbl_chitietphieuxuat ct
                            JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                            WHERE MaPhieuXuat = ?", [$id]);
        return view('admin.PhieuXuat.xemCT', ['px' => $px[0], 'ct' => $ct]);
    }

    public function xoaPX($id){
        DB::delete("DELETE FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ?", [$id]);
        DB::delete("DELETE FROM tbl_phieuxuat WHERE MaPhieuXuat = ?", [$id]);
        return redirect()->route('xemPX')->with('success', 'Xóa thành công!');
    }

    public function taoPX(){
        $maPX = 'PX' . date('YmdHis');
        $products = SanPham::all();
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        return view('admin.PhieuXuat.themPX', ['maPX' => $maPX, 'listLSP' => $listLSP], compact('products'));
    }

    public function xuLyLapPX(Request $request)
    {
        $maPX = $request->maPhieu;
        $thoiGianTao = date('Y-m-d H:i:s');
        $tenTK = $request->nguoiLap;
        $maTK = DB::select("SELECT * FROM tbl_taikhoan WHERE TenTaiKhoan = ?", [$tenTK]);
        $tongSL = 0;
        $trangThai = 0;
        $maDH = $request->maDH;
        $lyDoKhac = $request->lyDoKhac;
        if(empty($lyDoKhac)){
            $lyDoKhac = 'Xuất bán';
        }
        
        if ($maPX) {
            $phieuxuat = new PhieuXuat();
            $phieuxuat->MaPhieuXuat = $maPX;
            $phieuxuat->MaTaiKhoan = $maTK[0]->MaTaiKhoan;
            $phieuxuat->LyDoXuat = $lyDoKhac;
            $phieuxuat->MaDonHang = $maDH;
            $phieuxuat->TongSoLuong = $tongSL;
            $phieuxuat->TrangThai = $trangThai;
            $phieuxuat->ThoiGianTao = $thoiGianTao;
            $phieuxuat->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Mời bạn kiểm tra lại thông tin!!']);
    }

    public function xuLyLapPXCT1(Request $request){
        $maCTPX = 'CTPX' . uniqid();
        $maPX = $request->maPX;
        $maSP = $request->maSP;
        $soLuong = $request->soLuong;

        $sl = DB::select("SELECT SoLuongTrongKho FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return response()->json(['success' => false, 'message' => 'Số lượng trong kho không đủ']);
        }
        if ($maPX) {
            $ktSanPhamTonTai = ChiTietPhieuXuat::where('MaPhieuXuat', $maPX)
                                ->where('MaSanPham', $maSP)
                                ->first();
            if($ktSanPhamTonTai){
                $ktSanPhamTonTai->SoLuong += $soLuong;
                $ktSanPhamTonTai->save();
                $message = 'Cập nhật thành công';
            }else{
                $ctpx = new ChiTietPhieuXuat();
                $ctpx->MaCTPX = $maCTPX;
                $ctpx->MaPhieuXuat = $maPX;
                $ctpx->MaSanPham = $maSP;
                $ctpx->SoLuong = $soLuong;    
                $ctpx->save();
                $message = 'Thêm thành công';
            }
            
            $tenSP = DB::select("SELECT TenSanPham FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
            $tenSP1 = $tenSP[0]->TenSanPham;
            return response()->json([
                'success' => true,
                'message' => $message,
                'maCTPX' => $maCTPX,
                'maPX' => $maPX,
                'maSP' => $tenSP1,
                'soLuong' => $ktSanPhamTonTai ? $ktSanPhamTonTai->SoLuong : $soLuong,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        
    }
   
    public function taoPXCT(Request $request){
        $messages = [
            'maSP.required' => 'Vui lòng chọn sản phẩm',
            'soLuong.required' => 'Vui lòng nhập số lượng',
        ];
        $valid = $request->validate([
            'maSP' => 'required',
            'soLuong' => 'required',
        ], $messages);

        $maCTPX = 'CTPX' . uniqid();
        $maPX = $request->maPXSua;
        $maSP = $request->maSP;
        $soLuong = $request->soLuong;

        $sl = DB::select("SELECT SoLuongTrongKho FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return redirect()->back()->withInput()->withErrors(['soLuong' => 'Số lượng sản phẩm trong kho không đủ (Số lượng trong kho: ' . $sl[0]->SoLuongTrongKho . ')']);
        }

        $ktSanPhamTonTai = ChiTietPhieuXuat::where('MaPhieuXuat', $maPX)
                            ->where('MaSanPham', $maSP)
                            ->first();
        if($ktSanPhamTonTai){
            $ktSanPhamTonTai->SoLuong += $soLuong;
            $ktSanPhamTonTai->save();
            $message = 'Cập nhật thành công';
        }else{
            $ctpx = new ChiTietPhieuXuat();
            $ctpx->MaCTPX = $maCTPX;
            $ctpx->MaPhieuXuat = $maPX;
            $ctpx->MaSanPham = $maSP;
            $ctpx->SoLuong = $soLuong;
            $ctpx->save();
            $message = 'Thêm thành công';
        }
        return redirect()->route('suaPX', ['id' => $maPX])->with('success', $message);
        
        
    }

    public function xoaCT($id, $maPX){
        DB::delete("DELETE FROM tbl_chitietphieuxuat WHERE MaCTPX = ?", [$id]);      
        return redirect()->route('taoCT', ['id' => $maPX]);   
    }

    public function xoaCTPXS($id, $maPX){
        DB::delete("DELETE FROM tbl_chitietphieuxuat WHERE MaCTPX = ?", [$id]);      
        return redirect()->route('suaPX', ['id' => $maPX])->with('success', 'Xóa thành công');   
    }

    public function luuPX($id){
        $ct = DB::select("SELECT * FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ?", [$id]);
        $tongSL = 0;
        foreach($ct as $i){
            $tongSL += $i->SoLuong;
        }
        PhieuXuat::where('MaPhieuXuat', $id)->update([
            'TongSoLuong' => $tongSL,
        ]);
        return redirect()->route('xemPX');
    }

    public function suaPX($id){
        $products = SanPham::all();
        $px = DB::select("SELECT px.*, tk.TenTaiKhoan
                        FROM tbl_phieuxuat px 
                        JOIN tbl_taikhoan tk ON px.MaTaiKhoan = tk.MaTaiKhoan
                        WHERE MaPhieuXuat = ?", [$id]);
        $ct = DB::select("SELECT ct.*, sp.TenSanPham
                            FROM tbl_chitietphieuxuat ct
                            JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                            WHERE MaPhieuXuat = ?", [$id]);
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        return view('admin.PhieuXuat.suaPX', ['px' => $px[0], 'ctpx' => $ct, 'listLSP' => $listLSP], compact('products'));
    }

    public function suaPXP(Request $request){
        $maPX = $request->maPX;
        $ctpx = DB::select("SELECT * FROM tbl_chitietphieuxuat WHERE MaPhieuXuat = ?", [$maPX]);
        $tongSL = 0;
        foreach($ctpx as $i){
            $tongSL += $i->SoLuong;
        }
        $tgSua = date('Y-m-d H:i:s');
        
        $trangThai1 = $request->trangThaiTruoc;
        $trangThai2 = $request->trangThai;
        if($trangThai2 == 1 && ($trangThai1 != $trangThai2)){
            $spMoi = [];
            foreach($ctpx as $ct){
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
        }elseif($trangThai2 == 0 && ($trangThai1 != $trangThai2)){
            foreach($ctpx as $ct){
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
        }

        PhieuXuat::where('MaPhieuXuat', $maPX)->update([
            'TongSoLuong' => $tongSL,
            'TrangThai' => $request->trangThai,
            'ThoiGianSua' => $tgSua,
        ]);
        return redirect()->route('xemPX');
    }

    public function updateSoLuong(Request $request)
    {
        $MaCTPX = $request->input('MaCTPX');
        $soLuong = $request->input('soLuong');

        $sl = DB::select("SELECT sp.SoLuongTrongKho 
                        FROM tbl_sanpham sp
                        JOIN tbl_chitietphieuxuat px ON px.MaSanPham = sp.MaSanPham
                        WHERE MaCTPX = ?", [$MaCTPX]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm trong kho không đủ']);
        }
        if ($MaCTPX) {
            ChiTietPhieuXuat::where('MaCTPX', $MaCTPX)->update([
                'SoLuong' => $soLuong,
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    }


    // public function danhSachSanPham(Request $request)
    // {
    //     $search = $request->input('q');
    //     $ids = $request->input('ids');

    //     if ($ids) {
    //         $products = SanPham::whereIn('MaSanPham', $ids)->get(['MaSanPham as id', 'TenSanPham as text']);
    //         return response()->json($products);
    //     }

    //     $products = SanPham::where('TenSanPham', 'LIKE', "%{$search}%")
    //         ->get(['MaSanPham as id', 'TenSanPham as text']);

    //     return response()->json($products);
    // }
}
