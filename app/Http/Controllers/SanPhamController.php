<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use App\Models\DanhMucTSKT;
use App\Models\ThongSoKyThuat;
use App\Models\SanPhamTSKT;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller
{
    public function TrangThemSanPham(){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        $allDanhMucCha = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('DanhMucCha', 0)->get();
        return view('admin.SanPham.ThemSanPham')->with(compact('allThuongHieu', 'allDanhMuc', 'allDanhMucCha'));
    }

    public function TrangLietKeSanPham(){
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->orderBy('MaThuongHieu', 'DESC')->paginate(5);
        return view('admin.SanPham.LietKeSanPham')->with(compact('allSanPham'));
    }

    public function ThemTSKTChoSanPham(Request $request){
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
                $select_TSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
                foreach($select_danhMucTSKT as $key1 => $danhMucTSKT){
                    $output.='<label>Chọn thông số kỹ thuật '.$danhMucTSKT->TenDMTSKT.'</label>';
                    $output.='<select name="ThongSoKyThuat'.$key1.'" class="form-control input-lg m-bot15 ThemTSKTChoSanPham ThongSoKyThuat" style="margin-bottom: 15px">';
                    $output.='<option>--- Chọn thông số kỹ thuật ---</option>';
                    foreach($select_TSKT as $key2 => $thongSoKyThuat){
                        if($thongSoKyThuat->MaDMTSKT == $danhMucTSKT->MaDMTSKT){
                            $output.='<option value="'.$thongSoKyThuat->MaTSKT.'">'.$thongSoKyThuat->TenTSKT.'</option>';
                        }
                    }
                    $output.='</select>';
                }
            }
        }
        echo $output;
    }

    public function ThemSanPham(Request $request){
        $data = $request->all();
         $validate = Validator::make( $request->all() ,[
             'TenSanPham' => 'required|max:250',
             'SlugSanPham' => 'required',
             'MaThuongHieu' => 'required',
             'MoTa' => 'required',
             'DanhMucCha' => 'required',
             'DanhMucCon' => '',
             'TrangThai' => 'required',
             'SoTien' => ['required', 'integer'],
             'HinhAnh' => ['required', 'image','mimes:jpeg,png,jpg,gif|max:2048'],
//                 'ThongSoKyThuat' => 'required',
              'ThoiGianBaoHanh' => ['required', 'integer'],
             'CanNang' =>['required', 'integer'],
             'ChieuDay'=>['required', 'integer'],
             'ChieuNgang'=>['required', 'integer'],
             'ChieuCao'=>['required', 'integer'],

             ],
             [
                 'TenSanPham.required' => 'Vui lòng điền tên sản phẩm',
                 'TenSanPham.max' => 'Tên sản phẩm dài quá 250 ký tự',
                 'SlugSanPham.required' => 'Vui lòng điền slug cho sản phẩm',
                 'DanhMucCha.required' => 'Vui lòng chọn Danh mục cho sản phẩm',
                 'MaThuongHieu.required' => 'Vui lòng chọn Thương hiệu cho sản phẩm',
                 'MoTa.required' => 'Vui lòng điền Mô tả cho sản phẩm',
                 'TrangThai.required' => 'Vui lòng chọn Trạng thái cho sản phẩm',
                 'SoTien.required' => 'Vui lòng điền giá cho sản phẩm',
                 'SoTien.integer' => 'Vui lòng điền số.',
                 'HinhAnh.required' => 'Vui lòng chọn hình ảnh cho sản phẩm',
                 'HinhAnh.image' => 'Vui lòng chọn đúng định dạng hình ảnh.',
                 'ThoiGianBaoHanh.integer' => 'Vui lòng điền số',
                 'ThoiGianBaoHanh.required' => 'Vui lòng điền thời gian bảo hành',
                 'CanNang.integer' =>'Vui lòng điền số',
                 'CanNang.required' =>'Vui lòng điền cân nặng',
                 'ChieuDay.integer'=>'Vui lòng điền số',
                 'ChieuDay.required'=>'Vui lòng điền chiều dày',
                 'ChieuNgang.integer'=>'Vui lòng điền số',
                 'ChieuNgang.required'=>'Vui lòng điền chiều ngang',
                 'ChieuCao.integer'=>'Vui lòng điền số',
                 'ChieuCao.required'=>'Vui lòng điền chiều cao',
             ]);

         if($validate->fails()){
//             dd($validate->errors());
             return redirect()->back()
                 ->withInput($request->input())
                 ->withErrors($validate->errors());
         }

        $maDanhMuc = '';
        $sanPham = new SanPham();
        $sanPham->TenSanPham = $data['TenSanPham'];
        $sanPham->SlugSanPham = $data['SlugSanPham'];
        if($data['DanhMucCon'] == false){
            $data['DanhMucCon'] = $data['DanhMucCha'];
            $sanPham->MaDanhMuc = $data['DanhMucCon'];
            $maDanhMuc = $data['DanhMucCon'];
        }else{
            $sanPham->MaDanhMuc = $data['DanhMucCon'];
            $maDanhMuc = $data['DanhMucCon'];
        }
        $sanPham->MaThuongHieu = $data['MaThuongHieu'];
        $sanPham->GiaSanPham = $data['SoTien'];
        $sanPham->MoTa = $data['MoTa'];
        $sanPham->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $sanPham->ThoiGianTao = now();
        $sanPham->ChieuCao = $data['ChieuCao'];
        $sanPham->ChieuNgang = $data['ChieuNgang'];
        $sanPham->ChieuDay = $data['ChieuDay'];
        $sanPham->CanNang = $data['CanNang'];
        $sanPham->ThoiGianBaoHanh = $data['ThoiGianBaoHanh'];

        $get_image = $request->HinhAnh;
        $path = 'upload/SanPham/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path, $new_image);
        $sanPham->HinhAnh = $new_image;
        $sanPham->save();
        // Them TSKT
        $maxMaSanPham = SanPham::Max('MaSanPham');
        $select_SoLuongTSKT = DanhMucTSKT::where('MaDanhMuc', $maDanhMuc)->get();
        foreach($select_SoLuongTSKT as $key => $thongSoKyThuat){
            $sanPhamTSKT = new SanPhamTSKT();
            $sanPhamTSKT->MaSanPham = $maxMaSanPham;
            $sanPhamTSKT->MaTSKT = $data['ThongSoKyThuat'.$key];
            $sanPhamTSKT->ThoiGianTao = now();
            $sanPhamTSKT->save();
        }
        return Redirect::to('trang-liet-ke-san-pham')->with('status', 'Thêm sản phẩm mới thành công');
    }

    public function TrangSuaSanPham($MaSanPham){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        $sanPham = SanPham::where('MaSanPham' ,$MaSanPham)->get();

        $maDanhMuc = SanPham::where('MaSanPham', $MaSanPham)->first();
        $danhMuc = DanhMuc::where('MaDanhMuc', $maDanhMuc['MaDanhMuc'])->first();

        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $danhMuc['MaDanhMuc'])->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allSanPhamTSKT = SanPhamTSKT::orderBy('MaTSKTSP', 'DESC')->where('MaSanPham', $MaSanPham)->get();
        return view('admin.SanPham.SuaSanPham')
        ->with(compact('sanPham', 'allThuongHieu', 'allDanhMuc', 'allDanhMucTSKT', 'allTSKT', 'danhMuc', 'allSanPhamTSKT'));
    }

    public function TrangSanPhamTSKT($MaSanPham){
        $maDanhMuc = SanPham::where('MaSanPham', $MaSanPham)->first();
        $danhMuc = DanhMuc::where('MaDanhMuc', $maDanhMuc['MaDanhMuc'])->first();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $danhMuc['MaDanhMuc'])->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allSanPhamTSKT = SanPhamTSKT::where('MaSanPham', $MaSanPham)->get();
        return view('admin.SanPham.LietKeSanPhamTSKT')
        ->with(compact('allDanhMucTSKT', 'allTSKT', 'allSanPhamTSKT'));
    }

    public function SuaTSKTChoSanPham(Request $request){
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
            }
        }
        echo $output;
    }

    public function SuaSanPham(Request $request, $MaSanPham){
        $validate = Validator::make( $request->all() ,[
            'TenSanPham' => 'required|max:250',
            'SlugSanPham' => 'required',
            'MaThuongHieu' => 'required',
            'MoTa' => 'required',
            'DanhMucCha' => 'required',
            'DanhMucCon' => '',
            'TrangThai' => 'required',
            'GiaSanPham' => ['required', 'integer'],
            'HinhAnh' => ['nullable', 'image','mimes:jpeg,png,jpg,gif|max:2048'],
//                 'ThongSoKyThuat' => 'required',
            'ThoiGianBaoHanh' => ['required', 'integer'],
            'CanNang' =>['required', 'integer'],
            'ChieuDay'=>['required', 'integer'],
            'ChieuNgang'=>['required', 'integer'],
            'ChieuCao'=>['required', 'integer'],

        ],
            [
                'TenSanPham.required' => 'Vui lòng điền tên sản phẩm',
                'TenSanPham.max' => 'Tên sản phẩm dài quá 250 ký tự',
                'SlugSanPham.required' => 'Vui lòng điền slug cho sản phẩm',
                'DanhMucCha.required' => 'Vui lòng chọn Danh mục cho sản phẩm',
                'MaThuongHieu.required' => 'Vui lòng chọn Thương hiệu cho sản phẩm',
                'MoTa.required' => 'Vui lòng điền Mô tả cho sản phẩm',
                'TrangThai.required' => 'Vui lòng chọn Trạng thái cho sản phẩm',
                'GiaSanPham.required' => 'Vui lòng điền giá cho sản phẩm',
                'GiaSanPham.integer' => 'Vui lòng điền số.',
                'HinhAnh.image' => 'Vui lòng chọn đúng định dạng hình ảnh.',
                'ThoiGianBaoHanh.integer' => 'Vui lòng điền số',
                'ThoiGianBaoHanh.required' => 'Vui lòng điền thời gian bảo hành',
                'CanNang.integer' =>'Vui lòng điền số',
                'CanNang.required' =>'Vui lòng điền cân nặng',
                'ChieuDay.integer'=>'Vui lòng điền số',
                'ChieuDay.required'=>'Vui lòng điền chiều dày',
                'ChieuNgang.integer'=>'Vui lòng điền số',
                'ChieuNgang.required'=>'Vui lòng điền chiều ngang',
                'ChieuCao.integer'=>'Vui lòng điền số',
                'ChieuCao.required'=>'Vui lòng điền chiều cao',
            ]);

        if($validate->fails()){
//             dd($validate->errors());
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validate->errors());
        }

        $data = $request->all();
        $sanPham = SanPham::find($MaSanPham);
        $sanPham->TenSanPham = $data['TenSanPham'];
        $sanPham->SlugSanPham = $data['SlugSanPham'];
        if($data['DanhMucCon'] == false){
            $data['DanhMucCon'] = $data['DanhMucCha'];
            $sanPham->MaDanhMuc = $data['DanhMucCon'];
        }else{
            $sanPham->MaDanhMuc = $data['DanhMucCon'];
        }
        $sanPham->MaThuongHieu = $data['MaThuongHieu'];
        $sanPham->GiaSanPham = $data['GiaSanPham'];
        $sanPham->ThoiGianBaoHanh = $data['ThoiGianBaoHanh'];
        $sanPham->MoTa = $data['MoTa'];
        $sanPham->TrangThai = $data['TrangThai'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $sanPham->ThoiGianSua = now();
        $sanPham->ChieuCao = $data['ChieuCao'];
        $sanPham->ChieuNgang = $data['ChieuNgang'];
        $sanPham->ChieuDay = $data['ChieuDay'];
        $sanPham->CanNang = $data['CanNang'];

        $get_image = $request->HinhAnh;
        if($get_image){
            // Xóa hình ảnh cũ
            $path_unlink = 'upload/SanPham/'.$sanPham->HinhAnh;
            if (file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // Thêm mới
            $path = 'upload/SanPham/';
            $get_name_image = $get_image->getClientOriginalName(); // hinh123.jpg
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $sanPham->HinhAnh = $new_image;
        }
        $sanPham->save();
        $idSPTSKT = SanPhamTSKT::where('MaSanPham', $MaSanPham)->get();
        foreach($idSPTSKT as $key => $value){
            $sanPhamTSKT = SanPhamTSKT::find($value['MaTSKTSP']);
            $sanPhamTSKT->MaTSKT = $data['ThongSoKyThuat'.$key];
            $sanPhamTSKT->ThoiGianSua = now();
            $sanPhamTSKT->save();
        }
        return Redirect::to('trang-liet-ke-san-pham')->with('status', 'Cập nhật sản phẩm thành công');
    }

    public function XoaSanPham($MaSanPham){

        $sanPham = SanPham::find($MaSanPham);
        $sanPham->update(['TrangThai'=>0]);

        return Redirect::to('trang-liet-ke-san-pham')->with('status', 'Xóa sản phẩm thành công');
    }

    public function KoKichHoatSanPham($MaSanPham){
        $sanPham = SanPham::find($MaSanPham);
        $sanPham->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-san-pham')->with('status', 'Không kích hoạt sản phẩm thành công');
    }

    public function KichHoatSanPham($MaSanPham){
        $sanPham = SanPham::find($MaSanPham);
        $sanPham->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-san-pham')->with('status', 'Kích hoạt sản phẩm thành công');
    }

    public function timKiem(Request $request)
    {
        $allSanPham = SanPham::where('TenSanPham', 'LIKE', "%{$request->TuKhoa}%")
            ->orWhere('SlugSanPham', 'LIKE', "%{$request->TuKhoa}%")
        ->get();
//        dd($kq);
        return view('admin.SanPham.LietKeSanPham')->with(compact('allSanPham'));
    }
}
