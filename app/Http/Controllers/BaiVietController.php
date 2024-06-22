<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BaiVietController extends Controller
{
    // Quản lý danh mục bài viết
    public function TrangThemDanhMucBV(){
        return view('admin.BaiViet.DanhMucBaiViet.ThemDanhMucBV');
    }

    public function TrangLietKeDanhMucBV(){
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->paginate(15);
        return view('admin.BaiViet.DanhMucBaiViet.LietKeDanhMucBV')->with(compact('allDanhMucBV'));
    }

    public function ThemDanhMucBV(Request $request){
        $data = $request->validate([
            'TenDanhMucBV' => 'required',
            'SlugDanhMucBV' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
        ],
        [
            'TenDanhMucBV.required' => 'Chưa điền tên danh mục bài viết',
            'SlugDanhMucBV.required' => 'Chưa điền slug cho danh mục bài viết',
            'MoTa.required' => 'Chưa điền Mô tả cho danh mục bài viết',
            'TrangThai.required' => 'Chưa điền Trạng thái cho danh mục bài viết',
        ]);
        $danhMucBV = new DanhMucBaiViet();
        $danhMucBV->TenDanhMucBV = $data['TenDanhMucBV'];
        $danhMucBV->SlugDanhMucBV = $data['SlugDanhMucBV'];
        $danhMucBV->MoTa = $data['MoTa'];
        $danhMucBV->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $danhMucBV->ThoiGianTao = now();
        $danhMucBV->save();
        return Redirect::to('trang-liet-ke-dmbv')->with('status', 'Thêm danh mục bài viết thành công');
    }

    public function TrangSuaDanhMucBV($MaDanhMucBV){
        $danhMucBaiViet = DanhMucBaiViet::where('MaDanhMucBV', $MaDanhMucBV)->first();
        return view('admin.BaiViet.DanhMucBaiViet.SuaDanhMucBV')->with(compact('danhMucBaiViet'));
    }

    public function SuaDanhMucBV(Request $request, $MaDanhMucBV){
        $data = $request->validate([
            'TenDanhMucBV' => 'required',
            'SlugDanhMucBV' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
        ],
        [
            'TenDanhMucBV.required' => 'Chưa điền tên danh mục bài viết',
            'SlugDanhMucBV.required' => 'Chưa điền slug cho danh mục bài viết',
            'MoTa.required' => 'Chưa điền Mô tả cho danh mục bài viết',
            'TrangThai.required' => 'Chưa điền Trạng thái cho danh mục bài viết',
        ]);
        $danhMucBV = DanhMucBaiViet::find($MaDanhMucBV);
        $danhMucBV->TenDanhMucBV = $data['TenDanhMucBV'];
        $danhMucBV->SlugDanhMucBV = $data['SlugDanhMucBV'];
        $danhMucBV->MoTa = $data['MoTa'];
        $danhMucBV->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $danhMucBV->ThoiGianSua = now();
        $danhMucBV->save();
        return Redirect::to('trang-liet-ke-dmbv')->with('status', 'Cập nhật danh mục bài viết thành công');
    }

    public function XoaDanhMucBV($MaDanhMucBV){
        $danhMucBV = DanhMuc::find($MaDanhMucBV)->delete();
        return Redirect::to('TrangLietKeDanhMucBV')->with('status', 'Xóa danh mục bài viết thành công');
    }

    public function KoKichHoatDanhMucBV($MaDanhMucBV){
        $danhMucBV = DanhMucBaiViet::find($MaDanhMucBV);
        $danhMucBV->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-dmbv')->with('status', 'Cập nhật tình trạng danh mục bài viết thành công');
    }

    public function KichHoatDanhMucBV($MaDanhMucBV){
        $danhMucBV = DanhMucBaiViet::find($MaDanhMucBV);
        $danhMucBV->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-dmbv')->with('status', 'Cập nhật tình trạng danh mục bài viết thành công');
    }

    // Quản lý bài viết

    public function TrangThemBaiViet(){
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->get();
        return view('admin.BaiViet.BaiViet.ThemBaiViet')->with(compact('allDanhMucBV'));
    }

    public function TrangLietKeBaiViet(){
        $allBaiViet = BaiViet::orderBy('MaDanhMucBV', 'DESC')->paginate(20);
        return view('admin.BaiViet.BaiViet.LietKeBaiViet')->with(compact('allBaiViet'));
    }

    public function ThemBaiViet(Request $request){
        $data = $request->all();
        $validate = Validator::make ($request->all() ,[
            'TenBaiViet' => 'required',
            'SlugBaiViet' => 'required',
            'MaDanhMucBV' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
            'HinhAnh' => 'required',
        ],
        [
            'TenBaiViet.required' => 'Chưa điền tên bài viết',
            'SlugBaiViet.required' => 'Chưa điền slug cho bài viết',
            'MaDanhMucBV.required' => 'Chưa chọn Mã danh mục cho bài viết',
            'MoTa.required' => 'Chưa điền Mô tả cho bài viết',
            'TrangThai.required' => 'Chưa điền Trạng thái cho bài viết',
            'HinhAnh.required' => 'Chưa chọn hình ảnh cho bài viết',
        ]);

        if ($validate->fails()){
            return Redirect::back()
                ->withErrors($validate->errors())
                ->withInput($request->input());
        }

        $baiViet = new BaiViet();
        $baiViet->TenBaiViet = $data['TenBaiViet'];
        $baiViet->SlugBaiViet = $data['SlugBaiViet'];
        $baiViet->MaDanhMucBV = $data['MaDanhMucBV'];
        $baiViet->MoTa = $data['MoTa'];
        $baiViet->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $baiViet->ThoiGianTao = now();

        $get_image = $request->HinhAnh;
        $path = 'upload/BaiViet/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path, $new_image);

        $baiViet->HinhAnh = $new_image;
        $baiViet->save();

        return Redirect::to('trang-liet-ke-bai-viet')->with('status', 'Thêm bài viết thành công');
    }

    public function KoKichHoatBaiViet($MaBaiViet){
        $baiViet = BaiViet::find($MaBaiViet);
        $baiViet->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-bai-viet')->with('status', 'Cập nhật tình trạng bài viết thành công');
    }

    public function KichHoatBaiViet($MaBaiViet){
        $baiViet = BaiViet::find($MaBaiViet);
        $baiViet->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-bai-viet')->with('status', 'Cập nhật tình trạng bài viết thành công');
    }

    public function TrangSuaBaiViet($MaBaiViet){
        $baiViet = BaiViet::where('MaBaiViet' ,$MaBaiViet)->first();
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->get();
        return view('admin.BaiViet.BaiViet.SuaBaiViet')->with(compact('baiViet', 'allDanhMucBV'));
    }

    public function SuaBaiViet(Request $request, $MaBaiViet){
        $data = $request->validate([
            'TenBaiViet' => 'required',
            'SlugBaiViet' => 'required',
            'MaDanhMucBV' => 'required',
            'MoTa' => 'required',
            'TrangThai' => 'required',
            'HinhAnh' => '',
        ],
        [
            'TenBaiViet.required' => 'Chưa điền tên bài viết',
            'SlugBaiViet.required' => 'Chưa điền slug cho bài viết',
            'MaDanhMucBV.required' => 'Chưa chọn Mã danh mục cho bài viết',
            'MoTa.required' => 'Chưa điền Mô tả cho bài viết',
            'TrangThai.required' => 'Chưa điền Trạng thái cho bài viết',
        ]);
        $baiViet = BaiViet::find($MaBaiViet);
        $baiViet->TenBaiViet = $data['TenBaiViet'];
        $baiViet->SlugBaiViet = $data['SlugBaiViet'];
        $baiViet->MaDanhMucBV = $data['MaDanhMucBV'];
        $baiViet->MoTa = $data['MoTa'];
        $baiViet->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $baiViet->ThoiGianSua = now();


        $get_image = $request->HinhAnh;
        if($get_image){
            // Xóa hình ảnh cũ
            $path_unlink = 'upload/BaiViet/'.$baiViet->HinhAnh;
            if (file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // Thêm mới
            $path = 'upload/BaiViet/';
            $get_name_image = $get_image->getClientOriginalName(); // hinh123.jpg
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $baiViet->HinhAnh = $new_image;
        }
        $baiViet->save();
        return Redirect::to('trang-liet-ke-bai-viet')->with('status', 'Cập nhật bài viết thành công');
    }

    public function XoaBaiViet($MaBaiViet){
        $baiViet = BaiViet::find($MaBaiViet);
       $baiViet->TrangThai = 0;
       $baiViet->save();
        return Redirect::to('TrangLietKeBaiViet')->with('status', 'Xóa bài viết thành công');
    }

    public  function timKiemBV( Request $request)
    {
        $keyword = $request->TuKhoa;
        $allBaiViet = BaiViet::where('TenBaiViet', 'like', "%$keyword%")
            ->orWhereHas('DanhMucBV', function ($query) use ($keyword) {
                $query->where('TenDanhMucBV', 'like', "%$keyword%");
            })
                ->get();
        return view('admin.BaiViet.BaiViet.LietKeBaiViet')->with(compact('allBaiViet'));
    }

    public function timKiemDMBV(Request $request)
    {
        $allDanhMucBV = DanhMucBaiViet::where('TenDanhMucBV', 'like', "%{$request->TuKhoa}%")
                    ->orWhere('MoTa', 'like', "%{$request->TuKhoa}%")
                    ->get();
        return view('admin.BaiViet.DanhMucBaiViet.LietKeDanhMucBV')->with(compact('allDanhMucBV'));
    }
}
