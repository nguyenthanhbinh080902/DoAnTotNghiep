<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\Redirect;

class ThuongHieuController extends Controller
{
    public function TrangThemThuongHieu(){
        return view('admin.ThuongHieu.ThemThuongHieu');
    }

    public function TrangLietKeThuongHieu(){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->paginate(5);
        return view('admin.ThuongHieu.LietKeThuongHieu')->with(compact('allThuongHieu'));
    }

    public function ThemThuongHieu(Request $request){
        $data = $request->validate([
            'TenThuongHieu' => 'required|unique:tbl_thuonghieu|max:50',
            'SlugThuongHieu' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
            'HinhAnh' => 'required',
        ],
        [
            'TenThuongHieu.unique' => 'Trùng tên thương hiệu với một thương hiệu khác',
            'TenThuongHieu.required' => 'Vui lòng điền tên thương hiệu',
            'TenThuongHieu.max' => 'Tên thương hiệu dài quá 50 ký tự',
            'SlugThuongHieu.required' => 'Vui lòng điền slug cho thương hiệu',
            'MoTa.required' => 'Vui lòng điền Mô tả cho thương hiệu',
            'TrangThai.required' => 'Vui lòng điền Trạng thái cho thương hiệu',
            'HinhAnh.required' => 'Vui lòng chọn hình ảnh cho thương hiệu',
        ]);
        $thuongHieu = new ThuongHieu();
        $thuongHieu->TenThuongHieu = $data['TenThuongHieu'];
        $thuongHieu->SlugThuongHieu = $data['SlugThuongHieu'];
        $thuongHieu->MoTa = $data['MoTa'];
        $thuongHieu->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $thuongHieu->ThoiGianTao = now();

        $get_image = $request->HinhAnh;
        $path = 'upload/ThuongHieu/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path, $new_image);

        $thuongHieu->HinhAnh = $new_image;
        $thuongHieu->save();

        return Redirect::to('trang-liet-ke-thuong-hieu')->with('status', 'Thêm thương hiệu sản phẩm thành công');
    }

    public function KoKichHoatThuongHieu($MaThuongHieu){
        $thuongHieu = ThuongHieu::find($MaThuongHieu);
        $thuongHieu->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-thuong-hieu')->with('status', 'Cập nhật tình trạng thương hiệu thành công');
    }

    public function KichHoatThuongHieu($MaThuongHieu){
        $thuongHieu = ThuongHieu::find($MaThuongHieu);
        $thuongHieu->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-thuong-hieu')->with('status', 'Cập nhật tình trạng thương hiệu thành công');
    }

    public function TrangSuaThuongHieu($MaThuongHieu){
        $thuongHieu = ThuongHieu::where('MaThuongHieu' ,$MaThuongHieu)->get();
        return view('admin.ThuongHieu.SuaThuongHieu', compact('thuongHieu'));
    }

    public function SuaThuongHieu(Request $request, $MaThuongHieu){
         $data = $request->validate([
            'TenThuongHieu' => 'required|max:50',
            'SlugThuongHieu' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
        ],
        [
            'TenThuongHieu.required' => 'Vui lòng điền tên thương hiệu mới',
            'TenThuongHieu.max' => 'Tên thương hiệu dài quá 50 ký tự',
            'SlugThuongHieu.required' => 'Vui lòng điền slug cho thương hiệu mới',
            'MoTa.required' => 'Vui lòng điền Mô tả cho thương hiệu mới',
            'TrangThai.required' => 'Chưa điền Trạng thái cho thương hiệu',
        ]);
        $thuongHieu = ThuongHieu::find($MaThuongHieu);
        $thuongHieu->TenThuongHieu = $data['TenThuongHieu'];
        $thuongHieu->SlugThuongHieu = $data['SlugThuongHieu'];
        $thuongHieu->MoTa = $data['MoTa'];
        $thuongHieu->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $thuongHieu->ThoiGianSua = now();


        $get_image = $request->HinhAnh;
        if($get_image){
            // Xóa hình ảnh cũ
            $path_unlink = 'upload/ThuongHieu/'.$thuongHieu->HinhAnh;
            if (file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // Thêm mới
            $path = 'upload/ThuongHieu/';
            $get_name_image = $get_image->getClientOriginalName(); // hinh123.jpg
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $thuongHieu->HinhAnh = $new_image;
        }
        $thuongHieu->save();
        return Redirect::to('trang-liet-ke-thuong-hieu')->with('status', 'Cập nhật thương hiệu sản phẩm thành công');
    }

    public function XoaThuongHieu($MaThuongHieu){
        $thuongHieu = ThuongHieu::find($MaThuongHieu);
        $thuongHieu->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-thuong-hieu')->with('status', 'Vô hiệu hóa thương hiệu sản phẩm thành công');
    }

    public function timKiem(Request $request)
    {
        $allThuongHieu = ThuongHieu::where('SlugThuongHieu', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('SlugThuongHieu', 'LIKE', "%{$request->TuKhoa}%")
            ->get();
        return view('admin.ThuongHieu.LietKeThuongHieu')->with(compact('allThuongHieu'));
    }
}
