<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucTSKT;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Redirect;

class DanhMucTSKTController extends Controller
{
    public function TrangThemDanhMucTSKT(){
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        return view('admin.ThongSoKyThuat.DanhMucTSKT.ThemDanhMucTSKT')->with(compact('allDanhMuc'));
    }

    public function TrangLietKeDanhMucTSKT(){
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDanhMuc', 'DESC')->paginate(5);
        return view('admin.ThongSoKyThuat.DanhMucTSKT.LietKeDanhMucTSKT')->with(compact('allDanhMucTSKT'));
    }

    public function ThemDanhMucTSKT(Request $request){
        $data = $request->validate([
            'TenDMTSKT' => 'required|max:250',
            'SlugDMTSKT' => 'required',
            'MoTa' => 'required',
            'DanhMucCha' => 'required',
            'DanhMucCon' => '',
            'TrangThai' => 'required',
        ],
        [
            'TenDMTSKT.required' => 'Chưa điền tên danh mục thông số kỹ thuật',
            'TenDMTSKT.max' => 'Tên danh mục thông số kỹ thuật dài quá 250 ký tự',
            'SlugDMTSKT.required' => 'Chưa điền slug cho danh mục thông số kỹ thuật',
            'DanhMucCha.required' => 'Chưa điền Danh mục cho danh mục thông số kỹ thuật',
            'MoTa.required' => 'Chưa điền Mô tả cho danh mục thông số kỹ thuật',
            'TrangThai.required' => 'Chưa điền Trạng thái cho danh mục thông số kỹ thuật',
        ]);
        // $data = $request->all();
        $danhMucTSKT = new DanhMucTSKT();
        $danhMucTSKT->TenDMTSKT = $data['TenDMTSKT'];
        $danhMucTSKT->SlugDMTSKT = $data['SlugDMTSKT'];
        if($data['DanhMucCon'] == false){
            $data['DanhMucCon'] = $data['DanhMucCha'];
            $danhMucTSKT->MaDanhMuc = $data['DanhMucCon'];
        }else{
            $danhMucTSKT->MaDanhMuc = $data['DanhMucCon'];
        }
        $danhMucTSKT->MoTa = $data['MoTa'];
        $danhMucTSKT->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $danhMucTSKT->ThoiGianTao = now();

        $danhMucTSKT->save();
        return Redirect::to('trang-liet-ke-danh-muc-tskt')->with('status', 'Tạo danh mục thông số kỹ thuật thành công');
    }

    public function TrangSuaDanhMucTSKT($MaDMTSKT){
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        $danhMucTSKT = DanhMucTSKT::where('MaDMTSKT', $MaDMTSKT)->get();
        return view('admin.ThongSoKyThuat.DanhMucTSKT.SuaDanhMucTSKT', compact('danhMucTSKT', 'allDanhMuc'));
    }

    public function SuaDanhMucTSKT(Request $request, $MaDMTSKT){
        $data = $request->validate([
            'TenDMTSKT' => 'required|max:250',
            'SlugDMTSKT' => 'required',
            'MoTa' => 'required',
            'DanhMucCha' => 'required',
            'DanhMucCon' => '',
            'TrangThai' => 'required',
        ],
        [
            'TenDMTSKT.required' => 'Chưa điền tên danh mục thông số kỹ thuật',
            'TenDMTSKT.max' => 'Tên danh mục thông số kỹ thuật dài quá 250 ký tự',
            'SlugDMTSKT.required' => 'Chưa điền slug cho danh mục thông số kỹ thuật',
            'DanhMucCha.required' => 'Chưa điền Danh mục cho danh mục thông số kỹ thuật',
            'MoTa.required' => 'Chưa điền Mô tả cho danh mục thông số kỹ thuật',
            'TrangThai.required' => 'Chưa điền Trạng thái cho danh mục thông số kỹ thuật',
        ]);
        // $data = $request->all();
        $danhMucTSKT = DanhMucTSKT::find($MaDMTSKT);
        $danhMucTSKT->TenDMTSKT = $data['TenDMTSKT'];
        $danhMucTSKT->SlugDMTSKT = $data['SlugDMTSKT'];
        if($data['DanhMucCon'] == false){
            $data['DanhMucCon'] = $data['DanhMucCha'];
            $danhMucTSKT->MaDanhMuc = $data['DanhMucCon'];
        }else{
            $danhMucTSKT->MaDanhMuc = $data['DanhMucCon'];
        }
        $danhMucTSKT->MoTa = $data['MoTa'];
        $danhMucTSKT->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $danhMucTSKT->ThoiGianTao = now();

        $danhMucTSKT->save();
        return Redirect::to('trang-liet-ke-danh-muc-tskt')->with('status', 'Cập nhật danh mục thông số kỹ thuật thành công');
    }

    public function XoaDanhMucTSKT($MaDMTSKT){
        $danhMucTSKT = DanhMucTSKT::find($MaDMTSKT);
        $danhMucTSKT->TrangThai = 0;
        $danhMucTSKT->save();
        return Redirect::to('trang-liet-ke-danh-muc-tskt')->with('status', 'Vô hiệu hóa danh mục thông số kỹ thuật thành công');
    }

    public function timKiem(Request $request)
    {
        $allDanhMucTSKT = DanhMucTSKT::where('MoTa', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('SlugDMTSKT', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('TenDMTSKT', 'LIKE', "%{$request->TuKhoa}%")
            ->get();
        return view('admin.ThongSoKyThuat.DanhMucTSKT.LietKeDanhMucTSKT')->with(compact('allDanhMucTSKT'));
    }
}
