<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use App\Models\DanhMucTSKT;
use App\Models\ThongSoKyThuat;
use App\Models\SanPhamTSKT;
use App\Models\PhieuBaoHanh;
use App\Models\ChiTietPhieuBaoHanh;
use App\Models\LichSuBaoHanh;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class BaoHanhController extends Controller
{
    public function TrangLietKeBaoHanh(){
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->paginate(20);
        return view('admin.BaoHanh.LietKeBaoHanhSanPham')->with(compact('allSanPham'));
    }

    public function Test(){
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addYear();
             
       echo $currentDateTime->addMonths(18);
    }

    public function TrangLietKePhieuBaoHanh(){
        $allPhieuBaoHanh = PhieuBaoHanh::orderBy('MaPhieuBaoHanh', 'DESC')->paginate(10);
        return view('admin.BaoHanh.LietKePhieuBaoHanh')->with(compact('allPhieuBaoHanh'));
    }

    public function TrangChiTietPhieuBaoHanh($order_code){
        $allCTPBH = ChiTietPhieuBaoHanh::orderBy('MaCTPBH', 'DESC')->where('order_code', $order_code)->get();
        return view('admin.BaoHanh.ChiTietPhieuBaoHanh')->with(compact('allCTPBH'));
    }

    public function TrangThemLichSuBaoHanh($MaCTPBH){
        $chiTietPBH = ChiTietPhieuBaoHanh::where('MaCTPBH', $MaCTPBH)->first();
        return view('admin.BaoHanh.TaoLichSuBaoHanh')->with(compact('MaCTPBH', 'chiTietPBH'));
    }

    public function ThemLichSuBaoHanh(Request $request, $MaCTPBH){
        $data = $request->all();
        $chiTietPBH = ChiTietPhieuBaoHanh::where('MaCTPBH', $MaCTPBH)->first();
        $lichSuBaoHanh = new LichSuBaoHanh();
        $lichSuBaoHanh->MaSanPham = $chiTietPBH['MaSanPham'];
        $lichSuBaoHanh->order_code = $chiTietPBH['order_code'];
        $lichSuBaoHanh->SoLuong = $data['SoLuong'];
        $lichSuBaoHanh->TinhTrang = $data['TinhTrang'];
        $lichSuBaoHanh->NgayBaoHanh = Carbon::now();
        $lichSuBaoHanh->ThoiGianTra = $data['ThoiGianTra'];
        $lichSuBaoHanh->save();
        return Redirect::to('TrangLietKeLichSuBaoHanh')->with('status', 'Thêm lịch sử bảo hành sản phẩm thành công');
    }

    public function TrangLietKeLichSuBaoHanh(){
        $lichSuBaoHanh = LichSuBaoHanh::orderBy('MaCTLSBH', 'DESC')->paginate(20);
        return view('admin.BaoHanh.LietKeLichSuBaoHanh')->with(compact('lichSuBaoHanh'));
    }
}
