<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuTraHang;
use App\Models\PhieuTraHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SanPham;

class PhieuTraHangController extends Controller
{
    //
    public function xem(){
        $pth = DB::table('tbl_phieutrahang')
                ->join('tbl_taikhoan', 'tbl_phieutrahang.MaTaiKhoan', '=', 'tbl_taikhoan.MaTaiKhoan')
                ->join('tbl_nhacungcap', 'tbl_phieutrahang.MaNhaCungCap', '=', 'tbl_nhacungcap.MaNhaCungCap')
                ->leftJoin('tbl_chitietphieutrahang', 'tbl_phieutrahang.MaPhieuTraHang', '=', 'tbl_chitietphieutrahang.MaPhieuTraHang')
                ->select('tbl_phieutrahang.*', 'tbl_taikhoan.TenTaiKhoan', 'tbl_nhacungcap.TenNhaCungCap',
                        DB::raw('COUNT(tbl_chitietphieutrahang.MaCTPTH) as soCTPTH'))
                ->groupBy('tbl_phieutrahang.MaPhieuTraHang')
                ->orderByDesc('tbl_phieutrahang.ThoiGianTao')
                ->paginate(5);

        return view('admin.PhieuTraHang.lietKeTH', ['data' => $pth]);
    } 

    public function xemCTPTH($id){
        $pth = DB::select("SELECT pth.*, tk.TenTaiKhoan, ncc.TenNhaCungCap
                        FROM tbl_phieutrahang pth 
                        JOIN tbl_taikhoan tk ON pth.MaTaiKhoan = tk.MaTaiKhoan
                        JOIN tbl_nhacungcap ncc ON pth.MaNhaCungCap = ncc.MaNhaCungCap
                        WHERE MaPhieuTraHang = ?", [$id]);
        $ctth = DB::select("SELECT ct.*, sp.TenSanPham
                        FROM tbl_chitietphieutrahang ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuTraHang = ?", [$id]);
        return view('admin.PhieuTraHang.xemCT', ['pth' => $pth[0], 'ctth' => $ctth]);
    }

    public function luuPTH($id){

        $ctpth = DB::select("SELECT * FROM tbl_chitietphieutrahang WHERE MaPhieuTraHang = ?", [$id]);
        $tongTien = 0;
        
        foreach($ctpth as $t){
            $tien = $t->SoLuong * $t->GiaSanPham;
            $tongTien += $tien;
        }
        PhieuTraHang::where('MaPhieuTraHang', $id)->update([
            'TongTien' => $tongTien,
        ]);
        $pth = DB::select("SELECT * FROM tbl_phieutrahang WHERE MaPhieuTraHang = ?", [$id]);
        $maPN = $pth[0]->MaPhieuNhap;
        return redirect()->route('xemCTPN', ['id' => $maPN]);
    }
    public function xoaPTH($id){
        $pth = DB::select("SELECT * FROM tbl_phieutrahang WHERE MaPhieuTraHang = ?", [$id]);
        DB::delete("DELETE FROM tbl_chitietphieutrahang WHERE MaPhieuTraHang = ?", [$id]);
        DB::delete("DELETE FROM tbl_phieutrahang WHERE MaPhieuTraHang = ?", [$id]);

        
        $maPN = $pth[0]->MaPhieuNhap;
        return redirect()->route('xemCTPN', ['id' => $maPN]);
    }

    public function suaPTH($id){
        $pth = DB::select("SELECT pth.*, tk.TenTaiKhoan
                        FROM tbl_phieutrahang pth 
                        JOIN tbl_taikhoan tk ON pth.MaTaiKhoan = tk.MaTaiKhoan
                        WHERE MaPhieuTraHang = ?", [$id]);
        $maPN = $pth[0]->MaPhieuNhap;
        $ctpn = DB::select("SELECT ct.*, sp.TenSanPham
                        FROM tbl_chitietphieunhap ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuNhap = ?", [$maPN]);
        $ctpth = DB::select("SELECT ct.*, sp.TenSanPham
                    FROM tbl_chitietphieutrahang ct
                    JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                    WHERE MaPhieuTraHang = ?", [$id]);
        $products = SanPham::all();
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        return view('admin.PhieuTraHang.suaTH', ['pth' => $pth[0], 'ctpn' => $ctpn, 'ctpth' => $ctpth, 'listLSP' => $listLSP], compact('products'));
    }

    public function xuLySuaPTH(Request $request){
        $maPTH = $request->maPTH;
        $maPN = $request->maPNSua;
        $tgSua = date('Y-m-d H:i:s');
        $ctpth = DB::select("SELECT * FROM tbl_chitietphieutrahang WHERE MaPhieuTraHang = ?", [$maPTH]);
        $ctpn = DB::select("SELECT * FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$maPN]);
        $tongTien = 0;

        foreach($ctpth as $t){
            foreach($ctpn as $n){
                if($t->MaSanPham == $n->MaSanPham){
                    if($t->SoLuong > $n->SoLuong){
                        return redirect()->back()->with('error', 'Mời bạn kiểm tra lại số lượng sản phẩm!. Số lượng hiện tại không khớp với số lượng trong phiếu nhập!');
                    }
                    
                }
            }
            $tien = $t->SoLuong * $t->GiaSanPham;
            $tongTien += $tien;
        }
        
        $trangThai1 = $request->trangThaiTruoc;
        $trangThai2 = $request->trangThai;
        if($trangThai2 == 1 && ($trangThai1 != $trangThai2)){
            $spMoi = [];
            foreach($ctpth as $ct){
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
            foreach($ctpth as $ct){
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

        PhieuTraHang::where('MaPhieuTraHang', $maPTH)->update([
            'TongTien' => $tongTien,
            'TrangThai' => $request->trangThai,
            'ThoiGianSua' => $tgSua,
        ]);
        return redirect()->route('xemCTPN', ['id' => $maPN]);
    }

    public function xuLyLapTHCT(Request $request){
        $messages = [
            'maSP.required' => 'Vui lòng chọn sản phẩm',
            'soLuong.required' => 'Vui lòng nhập số lượng',
            'lyDo' => 'Vui lòng nhập lý do trả hàng',
        ];
        $valid = $request->validate([
            'maSP' => 'required',
            'soLuong' => 'required',
            'lyDo' => 'required',
        ], $messages);
        $maCTTH = 'CTTH' . uniqid();
        $maSP = $request->maSP;
        $soLuong = $request->soLuong;
        $maPTH = $request->maPTHSua;
        $maPN = $request->maPN;
        $lyDo = $request->lyDo;
        $gia = 0;

        $sl = DB::select("SELECT SoLuongTrongKho FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return redirect()->back()->withInput()->withErrors(['soLuong' => 'Số lượng sản phẩm trong kho không đủ (Số lượng trong kho: ' . $sl[0]->SoLuongTrongKho . ')']);
        }
        
        $ctpn = DB::select("SELECT * FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$maPN]);
        $kt = false;
        foreach($ctpn as $i){
            if($i->MaSanPham == $maSP){
                if($i->SoLuong < $soLuong){
                    return redirect()->back()->withInput()->withErrors(['soLuong' => 'Nhập quá số lượng trong phiếu nhập (Số lượng trong phiếu nhập: ' . $i->SoLuong . ')']);
                }
                $gia = $i->GiaSanPham;
                $kt = true;
                break;
            }
        }
        if(!$kt){
            return redirect()->back()->withInput()->withErrors(['maSP' => 'Không tìm thấy sản phẩm']);
        }
        
        if ($maPTH) {
            $ktSanPhamTonTai = ChiTietPhieuTraHang::where('MaPhieuTraHang', $maPTH)
                            ->where('MaSanPham', $maSP)
                            ->first();
            if($ktSanPhamTonTai){
                $ktSanPhamTonTai->SoLuong += $soLuong;
                $ktSanPhamTonTai->save();
                $message = 'Cập nhật thành công';
            }else{
                $ctth = new ChiTietPhieuTraHang();
                $ctth->MaCTPTH = $maCTTH;
                $ctth->MaPhieuTraHang = $maPTH;
                $ctth->MaSanPham = $maSP;
                $ctth->SoLuong = $soLuong;    
                $ctth->GiaSanPham = $gia;
                $ctth->LyDoTraHang = $lyDo;
                $ctth->save();
                $message = 'Thêm thành công';
            }
        }
        return redirect()->route('suaPTH', ['id' => $maPTH])->with('success', $message);  
    }

    public function updateSoLuong(Request $request)
    {
        $MaCTPTH = $request->input('MaCTPTH');
        $soLuong = $request->input('soLuong');
        $lyDoTraHang = $request->input('lyDoTraHang');
        $maSanPham = $request->input('maSanPham');
        $maPN = $request->input('maPN');
        $sl = DB::select("SELECT sp.SoLuongTrongKho 
                        FROM tbl_sanpham sp
                        JOIN tbl_chitietphieutrahang px ON px.MaSanPham = sp.MaSanPham
                        WHERE MaCTPTH = ?", [$MaCTPTH]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm trong kho không đủ']);
        }
        $ctpn = DB::select("SELECT ct.*
                        FROM tbl_chitietphieunhap ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuNhap = ? AND ct.MaSanPham = ?", [$maPN, $maSanPham]);

        if($ctpn[0]->SoLuong < $soLuong){
            return response()->json(['success' => false, 'message' => 'Nhập quá số lượng trong phiếu nhập']);
        }
        
        if ($MaCTPTH) {
            ChiTietPhieuTraHang::where('MaCTPTH', $MaCTPTH)->update([
                'SoLuong' => $soLuong,
                'LyDoTraHang' => $lyDoTraHang,
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    }

    public function xoaCTPTHS($id, $maPTH){
        DB::delete("DELETE FROM tbl_chitietphieutrahang WHERE MaCTPTH = ?", [$id]);      
        return redirect()->route('suaPTH', ['id' => $maPTH]);   
    }

    public function lapTH($id, $maNCC){
        $maTH = 'TH' . date('YmdHis');
        $products = SanPham::all();
        $ctpn = DB::select("SELECT ct.*, sp.TenSanPham
                        FROM tbl_chitietphieunhap ct
                        JOIN tbl_sanpham sp ON ct.MaSanPham = sp.MaSanPham
                        WHERE MaPhieuNhap = ?", [$id]);
        $listLSP = DB::select("SELECT MaDanhMuc, TenDanhMuc FROM tbl_danhmuc");
        return view('admin.PhieuTraHang.themTh', ['maTH' => $maTH, 'maPN' => $id, 'maNCC' => $maNCC, 'ctpn' => $ctpn, 'listLSP' => $listLSP], compact('products'));
    }

    public function xuLyLapTH(Request $request)
    {
        $maTH = $request->maPhieu;
        $maPN = $request->maPN;
        $maNCC = $request->maNCC;
        $thoiGianTao = date('Y-m-d H:i:s');
        $tenTK = $request->nguoiLap;
        $maTK = DB::select("SELECT * FROM tbl_taikhoan WHERE TenTaiKhoan = ?", [$tenTK]);
        $trangThai = 0;
        $tongTien = 0;
        
        if ($maTH) {
            $phieutrahang = new PhieuTraHang();
            $phieutrahang->MaPhieuTraHang = $maTH;
            $phieutrahang->MaPhieuNhap = $maPN;
            $phieutrahang->MaNhaCungCap = $maNCC;
            $phieutrahang->MaTaiKhoan = $maTK[0]->MaTaiKhoan;
            $phieutrahang->TrangThai = $trangThai;
            $phieutrahang->TongTien = $tongTien;
            $phieutrahang->ThoiGianTao = $thoiGianTao;
            $phieutrahang->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Mời bạn kiểm tra lại thông tin!!']);
    }

    public function xuLyLapTHCT1(Request $request){
        $maCTTH = 'CTTH' . uniqid();
        $maTH = $request->maTH;
        $maSP = $request->maSP;
        $maPN = $request->maPN;
        $soLuong = $request->soLuong;
        $lyDo = $request->lyDo;
        $gia = 0;

        $ctpn = DB::select("SELECT * FROM tbl_chitietphieunhap WHERE MaPhieuNhap = ?", [$maPN]);
        $kt = false;
        foreach($ctpn as $i){
            if($i->MaSanPham == $maSP){
                if($i->SoLuong < $soLuong){
                    return response()->json(['success' => false, 'message' => 'Nhập quá số lượng trong phiếu nhập']);
                }
                $gia = $i->GiaSanPham;
                $kt = true;
                break;
            }

        }
        if(!$kt){
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }

        $sl = DB::select("SELECT SoLuongTrongKho FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
        if($soLuong > $sl[0]->SoLuongTrongKho){
            return response()->json(['success' => false, 'message' => 'Số lượng trong kho không đủ']);
        }


        if ($maTH) {
            $ktSanPhamTonTai = ChiTietPhieuTraHang::where('MaPhieuTraHang', $maTH)
                                ->where('MaSanPham', $maSP)
                                ->first();
            if($ktSanPhamTonTai){
                $ktSanPhamTonTai->SoLuong += $soLuong;
                $ktSanPhamTonTai->save();
                $message = 'Cập nhật thành công';
            }else{
                $ctth = new ChiTietPhieuTraHang();
                $ctth->MaCTPTH = $maCTTH;
                $ctth->MaPhieuTraHang = $maTH;
                $ctth->MaSanPham = $maSP;
                $ctth->SoLuong = $soLuong;    
                $ctth->GiaSanPham = $gia;
                $ctth->LyDoTraHang = $lyDo;
                $ctth->save();
                $message = 'Thêm thành công';
            }
            
            $tenSP = DB::select("SELECT TenSanPham FROM tbl_sanpham WHERE MaSanPham = ?", [$maSP]);
            $tenSP1 = $tenSP[0]->TenSanPham;
            return response()->json([
                'success' => true,
                'message' => $message,
                'maCTTH' => $maCTTH,
                'maSP' => $tenSP1,
                'soLuong' => $ktSanPhamTonTai ? $ktSanPhamTonTai->SoLuong : $soLuong,
                'gia' => $gia,
                'lyDo' => $lyDo,
            ]);
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
