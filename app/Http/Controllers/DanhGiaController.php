<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Session;
use App\Models\TaiKhoan;
use App\Models\SanPham;
use App\Models\PhieuGiamGia;
use App\Models\PhieuGiamGiaNguoiDung;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GiaoHang;
use App\Models\DanhGia;
use App\Models\BinhLuan;
use App\Models\BaiViet;

use Illuminate\Support\Facades\Redirect;

class DanhGiaController extends Controller
{
    public function DanhGia(Request $request){
        $data = $request->validate([
            'NoiDung' => 'required',
            'MaSanPham' => 'required',
            'SoSao' => 'required',
        ],[
            'NoiDung.required' => 'Bạn chưa điền nội dung đánh giá',
            'MaSanPham.required' => 'Chọn sản phẩm để đánh giá',
            'SoSao.required' => 'Chọn số sao để đánh giá sản phẩm',
        ]);
        if(Empty(Session::get('user'))){
            return Redirect()->back()->with('error', 'Bạn hãy đăng nhập để có thể đánh giá sản phẩm');
        }elseif(Session::get('user')){
            $user = Session('user');
            $allDonHang = DonHang::orderBy('MaDonHang', 'DESC')->where('Email', $user['Email'])->get();
            $allChiTietDonHang = ChiTietDonHang::orderBy('MaCTDH', 'DESC')->where('MaSanPham', $data['MaSanPham'])->get();
            foreach($allDonHang as $key => $valueDH){
                foreach($allChiTietDonHang as $key => $valueCTDH){
                    if($valueDH->order_code == $valueCTDH->order_code){
                        $danhGia = new DanhGia();
                        $danhGia->Email = $user['Email'];
                        $danhGia->MaSanPham = $data['MaSanPham'];
                        $danhGia->NoiDung = $data['NoiDung'];
                        $danhGia->TrangThai = 1;
                        $danhGia->SoSao = $data['SoSao'];
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $danhGia->ThoiGianTao = now();
                        $danhGia->save();
                        return Redirect()->back()->with('message', 'Đánh giá của bạn về sản phẩm được lưu lại');
                    }
                }
            }
        }
        return Redirect()->back()->with('error', 'Bạn phải mua sản phẩm này mới có thể sử dụng chức năng đánh giá sản phẩm');
    }

    public function TrangLietKeDanhGia(){
        $allDanhGia = DanhGia::orderBy('MaSanPham', 'DESC')->paginate(5);
        return view('admin.DanhGia.LietKeDanhGia')->with(compact('allDanhGia'));
    }

    public function KoKichHoatDanhGia($MaDanhGia){
        $danhGia = DanhGia::find($MaDanhGia);
        $danhGia->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-danh-gia')->with('status', 'Cập nhật tình trạng đánh giá sản phẩm thành công');
    }

    public function KichHoatDanhGia($MaDanhGia){
        $danhGia = DanhGia::find($MaDanhGia);
        $danhGia->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-danh-gia')->with('status', 'Cập nhật tình trạng đánh giá sản phảm thành công');
    }

    public function XoaDanhGia($MaDanhGia){
        $danhGia = DanhGia::find($MaDanhGia);
        $danhGia->delete();
        return Redirect::to('trang-liet-ke-danh-gia')->with('status', 'Xóa đánh giá sản phẩm thành công');
    }

    public function BinhLuan(Request $request){
        $data = $request->validate([
            'NoiDung' => 'required',
            'MaBaiViet' => 'required',
        ],[
            'NoiDung.required' => 'Bạn chưa điền nội dung bình luận',
            'MaBaiViet.required' => 'Chọn bài viết để bình luận',
        ]);
        if(Empty(Session::get('user'))){
            return Redirect()->back()->with('error', 'Bạn hãy đăng nhập để có thể bình luận bài viết');
        }elseif(Session::get('user')){
            $user = Session('user');
            $binhLuan = new BinhLuan();
            $binhLuan->Email = $user['Email'];
            $binhLuan->MaBaiViet = $data['MaBaiViet'];
            $binhLuan->NoiDung = $data['NoiDung'];
            $binhLuan->TrangThai = 1;
            $binhLuan->BaiVietCha = 0;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $binhLuan->ThoiGianTao = now();
            $binhLuan->save();
            return Redirect()->back()->with('message', 'Bình luận bài viết được lưu lại thành công');
        }
    }

    public function TrangLietKeBinhLuan(){
        $allBinhLuan = BinhLuan::orderBy('MaBaiViet', 'DESC')->paginate(20);
        return view('admin.DanhGia.LietKeBinhLuan')->with(compact('allBinhLuan'));
    }

    public function KoKichHoatBinhLuan($MaBinhLuan){
        $binhLuan = BinhLuan::find($MaBinhLuan);
        $binhLuan->update(['TrangThai'=>0]);
        return Redirect::to('trang-liet-ke-binh-luan')->with('status', 'Cập nhật tình trạng bình luận bài viết thành công');
    }

    public function KichHoatBinhLuan($MaBinhLuan){
        $binhLuan = BinhLuan::find($MaBinhLuan);
        $binhLuan->update(['TrangThai'=>1]);
        return Redirect::to('trang-liet-ke-binh-luan')->with('status', 'Cập nhật tình trạng bình luận bài viết thành công');
    }

    public function XoaBinhLuan($MaBinhLuan){
        $binhLuan = BinhLuan::find($MaBinhLuan);
        $binhLuan->delete();
        return Redirect::to('trang-liet-ke-binh-luan')->with('status', 'Xóa bình luận bài viết thành công');
    }

    public function timKiemDanhGia(Request $request)
    {
        $keyword = $request->TuKhoa;
        $allDanhGia = DanhGia::where('Email','like',"%{$request->TuKhoa}%")
            ->orWhere('NoiDung','like',"%{$request->TuKhoa}%")
            ->orWhere('SoSao','like',"%{$request->TuKhoa}%")
            ->orWhereHas('SanPham', function ($query) use ($keyword){
                $query->where('TenSanPham', 'like', "%$keyword%");
            })
            ->get();
        return view('admin.DanhGia.LietKeDanhGia')->with(compact('allDanhGia'));
    }

    public function timKiemBinhLuan(Request $request)
    {
        $keyword = $request->TuKhoa;
        $allBinhLuan = BinhLuan::where('Email', 'like', "%{$request->TuKhoa}%")
            ->orWhere('NoiDung', 'like', "%{$request->TuKhoa}%")
            ->orWhereHas('BaiViet', function ($query) use($keyword){
                $query->where('TenBaiViet', 'like', "%$keyword%");
            })
            ->get();
        return view('admin.DanhGia.LietKeBinhLuan')->with(compact('allBinhLuan'));
    }
}
