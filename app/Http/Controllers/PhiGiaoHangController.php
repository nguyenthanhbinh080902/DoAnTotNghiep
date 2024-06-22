<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TinhThanhPho;
use App\Models\QuanHuyen;
use App\Models\XaPhuongThiTran;
use App\Models\PhiGiaoHang;
use Illuminate\Support\Facades\Redirect;

class PhiGiaoHangController extends Controller
{
    public function TrangLietKePhiGiaoHang(){
        $allPhiGiaoHang = PhiGiaoHang::orderBy('MaThanhPho', 'ASC')->paginate();
        return view('admin.PhiGiaoHang.LietKePhiGiaoHang')->with(compact('allPhiGiaoHang'));
    }

    public function TrangThemPhiGiaoHang(){
        $allThanhPho = TinhThanhPho::orderBy('MaThanhPho', 'ASC')->get();
        return view('admin.PhiGiaoHang.ThemPhiGiaoHang')->with(compact('allThanhPho'));
    }

    public function TrangSuaPhiGiaoHang($MaPhiGiaoHang){
        $phiGiaoHang = PhiGiaoHang::where('MaPhiGiaoHang', $MaPhiGiaoHang)->get();
        $allThanhPho = TinhThanhPho::orderBy('MaThanhPho', 'ASC')->get();
        $allQuanHuyen = QuanHuyen::orderBy('MaQuanHuyen', 'ASC')->get();
        $allXaPhuong = XaPhuongThiTran::orderBy('MaXaPhuong', 'ASC')->get();
        return view('admin.PhiGiaoHang.SuaPhiGiaoHang')->with(compact('allThanhPho', 'allQuanHuyen', 'allXaPhuong', 'phiGiaoHang'));
    }

    public function ChonDiaDiem(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="MaThanhPho"){
                $select_province = QuanHuyen::where('MaThanhPho', $data['ma_id'])->orderBy('MaQuanHuyen', 'ASC')->get();
                $output.='<option>--Chọn quận huyện--</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->MaQuanHuyen.'">'.$province->TenQuanHuyen.'</option>';
                }
            }else{
                $select_wards = XaPhuongThiTran::where('MaQuanHuyen', $data['ma_id'])->orderBy('MaXaPhuong', 'ASC')->get();
                $output.='<option>--Chọn xã phường--</option>';
                foreach($select_wards as $key => $wards){
                    $output.='<option value="'.$wards->MaXaPhuong.'">'.$wards->TenXaPhuong.'</option>';
                }
            }
        }
        echo $output;
    }

    public function ThemPhiGiaoHang(Request $request){
        $data = $request->validate([
            'MaThanhPho' => 'required',
            'MaQuanHuyen' => 'required',
            'MaXaPhuong' => 'required',
            'PhiGiaoHang' => 'required',
        ],
        [
            'MaThanhPho.required' => 'Chưa chọn thành phồ',
            'MaQuanHuyen.required' => 'Chưa chọn quận huyện',
            'MaXaPhuong.required' => 'Chưa chọn xã phường',
            'PhiGiaoHang.required' => 'Chưa điền phí giao hàng'
        ]);
        // $data = $request->all();
        $phiGiaoHang = new PhiGiaoHang();
        $phiGiaoHang->MaThanhPho = $data['MaThanhPho'];
        $phiGiaoHang->MaQuanHuyen = $data['MaQuanHuyen'];
        $phiGiaoHang->MaXaPhuong = $data['MaXaPhuong'];
        $phiGiaoHang->SoTien = $data['PhiGiaoHang'];
        $phiGiaoHang->save();
        return Redirect::to('trang-liet-ke-phi-giao-hang')->with('status', 'Thêm phí giao hàng thành công');
    }

    public function SuaPhiGiaoHang($MaPhiGiaoHang, Request $request){
        $data = $request->validate([
            'MaThanhPho' => 'required',
            'MaQuanHuyen' => 'required',
            'MaXaPhuong' => 'required',
            'PhiGiaoHang' => 'required',
        ],
        [
            'MaThanhPho.required' => 'Chưa chọn thành phồ',
            'MaQuanHuyen.required' => 'Chưa chọn quận huyện',
            'MaXaPhuong.required' => 'Chưa chọn xã phường',
            'PhiGiaoHang.required' => 'Chưa điền phí giao hàng'
        ]);
        // $data = $request->all();
        $phiGiaoHang = PhiGiaoHang::find($MaPhiGiaoHang);
        $phiGiaoHang->MaThanhPho = $data['MaThanhPho'];
        $phiGiaoHang->MaQuanHuyen = $data['MaQuanHuyen'];
        $phiGiaoHang->MaXaPhuong = $data['MaXaPhuong'];
        $phiGiaoHang->SoTien = $data['PhiGiaoHang'];
        $phiGiaoHang->save();
        return Redirect::to('trang-liet-ke-phi-giao-hang')->with('status', 'Cập nhật phí giao hàng thành công');
    }

    public function XoaPhiGiaoHang($MaPhiGiaoHang){
        $phiGiaoHang = PhiGiaoHang::find($MaPhiGiaoHang);
        $phiGiaoHang->SoTien = 0;
        $phiGiaoHang->save();
        return Redirect::to('trang-liet-ke-phi-giao-hang')->with('status', 'Xóa danh mục phí giao hàng thành công');
    }

    public function timKiem(Request $request)
    {
        $keyword = $request->TuKhoa;

        // Tìm kiếm trong các bảng liên quan
        $allPhiGiaoHang = PhiGiaoHang::query()
            ->where('SoTien', 'like', "%$keyword%")
            ->orWhereHas('TinhThanhPho', function ($query) use ($keyword) {
                $query->where('TenThanhPho', 'like', "%$keyword%");
            })
            ->orWhereHas('QuanHuyen', function ($query) use ($keyword) {
                $query->where('TenQuanHuyen', 'like', "%$keyword%");
            })
            ->orWhereHas('XaPhuongThiTran', function ($query) use ($keyword) {
                $query->where('TenXaPhuong', 'like', "%$keyword%");
            })
            ->get();
        return view('admin.PhiGiaoHang.LietKePhiGiaoHang')->with(compact('allPhiGiaoHang'));
    }
}
