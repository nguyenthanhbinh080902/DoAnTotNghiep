<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucTSKT;
use App\Models\DanhMuc;
use App\Models\ThongSoKyThuat;
use Illuminate\Support\Facades\Redirect;

class ThongSoKyThuatController extends Controller
{
    public function TrangThemTSKT(){
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        return view('admin.ThongSoKyThuat.TSKT.ThemTSKT')->with(compact('allDanhMucTSKT', 'allDanhMuc'));
    }

    public function TrangLietKeTSKT(){
        $allThongSoKyThuat = ThongSoKyThuat::orderBy('MaDMTSKT', 'DESC')->paginate(5);
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->get();
        return view('admin.ThongSoKyThuat.TSKT.LietKeTSKT')->with(compact('allThongSoKyThuat', 'allDanhMucTSKT'));
    }

    public function ChonDanhMucTSKT(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action'] == "DanhMucCha"){
                $select_danhMucCon = DanhMuc::where('DanhMucCha', $data['ma_id'])->orderBy('MaDanhMuc', 'DESC')->get();
                if($select_danhMucCon->isEmpty()){
                    $select_danhMucCha = DanhMuc::where('MaDanhMuc', $data['ma_id'])->get();
                    foreach($select_danhMucCha as $key => $danhMucCha){
                        $output.='<option value="'.$danhMucCha->MaDanhMuc.'">--- Không có danh mục con ---</option>';
                    }
                }elseif($select_danhMucCon->isNotEmpty()){
                    $output.='<option>--- Chọn danh mục con ---</option>';
                    foreach($select_danhMucCon as $key => $danhMucCon){
                        $output.='<option value="'.$danhMucCon->MaDanhMuc.'">'.$danhMucCon->TenDanhMuc.'</option>';
                    }
                }
            }elseif($data['action'] == "DanhMucCon"){
                $select_danhMucTSKT = DanhMucTSKT::where('MaDanhMuc', $data['ma_id'])->orderBy('MaDMTSKT', 'DESC')->get();
                $output.='<option>--- Chọn danh mục TSKT ---</option>';
                foreach($select_danhMucTSKT as $key => $danhMucTSKT){
                    $output.='<option value="'.$danhMucTSKT->MaDMTSKT.'">'.$danhMucTSKT->TenDMTSKT.'</option>';
                }
            }elseif($data['action'] == "DanhMucTSKT"){
                $select_thongSoKyThuat = ThongSoKyThuat::where('MaDMTSKT', $data['ma_id'])->orderBy('MaTSKT', 'DESC')->get();
                $output.='<option>--- Chọn Thông số kỹ thuật ---</option>';
                foreach($select_thongSoKyThuat as $key => $thongSoKyThuat){
                    $output.='<option value="'.$thongSoKyThuat->MaTSKT.'">'.$thongSoKyThuat->TenTSKT.'</option>';
                }
            }
        }
        echo $output;
    }

    public function ThemTSKT(Request $request){
        $data = $request->validate([
            'TenTSKT' => 'required|max:250',
            'SlugTSKT' => 'required',
            'MoTa' => 'required',
            'DanhMucTSKT' => ['required', 'integer'],
            'TrangThai' => 'required',
        ],
        [
            'TenTSKT.required' => 'Chưa điền tên thông số kỹ thuật',
            'TenTSKT.max' => 'Tên thông số kỹ thuật dài quá 250 ký tự',
            'SlugTSKT.required' => 'Chưa điền slug cho thông số kỹ thuật',
            'DanhMucTSKT.required' => 'Chưa chọn Danh mục cho thông số kỹ thuật',
            'DanhMucTSKT.integer' => 'Chưa chọn Danh mục cho thông số kỹ thuật',
            'MoTa.required' => 'Chưa điền Mô tả cho thông số kỹ thuật',
            'TrangThai.required' => 'Chưa chọn Trạng thái cho thông số kỹ thuật',
        ]);
        // $data = $request->all();
        $thongSoKyThuat = new ThongSoKyThuat();
        $thongSoKyThuat->TenTSKT = $data['TenTSKT'];
        $thongSoKyThuat->SlugTSKT = $data['SlugTSKT'];
        $thongSoKyThuat->MaDMTSKT = $data['DanhMucTSKT'];
        $thongSoKyThuat->MoTa = $data['MoTa'];
        $thongSoKyThuat->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $thongSoKyThuat->ThoiGianTao = now();
        $thongSoKyThuat->save();
        return Redirect::to('trang-liet-ke-tskt')->with('status', 'Thêm thông số kỹ thuật mới thành công');
    }

    public function XoaTSKT($MaTSKT){
        $thongSoKyThuat = ThongSoKyThuat::find($MaTSKT);
        $thongSoKyThuat->TrangThai = 0;
        $thongSoKyThuat->save();
        return Redirect::to('trang-liet-ke-tskt')->with('status', 'Xóa thông sỗ kỹ thuật thành công');
    }

    public function TrangSuaTSKT($MaTSKT){
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        $thongSoKyThuat = ThongSoKyThuat::where('MaTSKT', $MaTSKT)->get();
        return view('admin.ThongSoKyThuat.TSKT.SuaSTKT')->with(compact('allDanhMucTSKT', 'allDanhMuc', 'thongSoKyThuat'));
    }

    public function SuaTSKT(Request $request, $MaTSKT){
        $data = $request->validate([
            'TenTSKT' => 'required|max:250',
            'SlugTSKT' => 'required',
            'MoTa' => 'required',
            'DanhMucTSKT' => 'required',
            'TrangThai' => 'required',
        ],
        [
            'TenTSKT.required' => 'Chưa điền tên thông số kỹ thuật',
            'TenTSKT.max' => 'Tên thông số kỹ thuật dài quá 250 ký tự',
            'SlugTSKT.required' => 'Chưa điền slug cho thông số kỹ thuật',
            'DanhMucTSKT.required' => 'Chưa điền Danh mục cho thông số kỹ thuật',
            'MoTa.required' => 'Chưa điền Mô tả cho thông số kỹ thuật',
            'TrangThai.required' => 'Chưa điền Trạng thái cho thông số kỹ thuật',
        ]);
        // $data = $request->all();
        $thongSoKyThuat = ThongSoKyThuat::find($MaTSKT);
        $thongSoKyThuat->TenTSKT = $data['TenTSKT'];
        $thongSoKyThuat->SlugTSKT = $data['SlugTSKT'];
        $thongSoKyThuat->MaDMTSKT = $data['DanhMucTSKT'];
        $thongSoKyThuat->MoTa = $data['MoTa'];
        $thongSoKyThuat->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $thongSoKyThuat->ThoiGianSua = now();
        $thongSoKyThuat->save();
        return Redirect::to('trang-liet-ke-tskt')->with('status', 'Cập nhật thông số kỹ thuật thành công');
    }

    public function timKiem(Request $request)
    {
        $allThongSoKyThuat = ThongSoKyThuat::where('MoTa', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('SlugTSKT', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('TenTSKT', 'LIKE', "%{$request->TuKhoa}%")
            ->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->get();
        return view('admin.ThongSoKyThuat.TSKT.LietKeTSKT')->with(compact('allThongSoKyThuat', 'allDanhMucTSKT'));
    }
}
