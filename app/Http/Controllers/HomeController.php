<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\ChuongTrinhGiamGia;
use App\Models\DonHang;
use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
use App\Models\ThuongHieu;
use App\Models\TaiKhoan;
use App\Models\PhanQuyen;
use App\Models\TinhThanhPho;
use App\Models\PhanQuyenNguoiDung;
use App\Models\ThuongHieuDanhMuc;
use App\Models\DanhMucTSKT;
use App\Models\ThongSoKyThuat;
use App\Models\SanPhamTSKT;
use App\Models\DanhGia;
use App\Models\ChuongTrinhGiamGiaSP;
use App\Models\BinhLuan;

use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index(Request $request){
        $currentDate = Carbon::now();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->where('TrangThai', '1')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();
        $allCTGG =  ChuongTrinhGiamGia::with(['chuongTrinhGiamGiaSPs.SanPham'])
            ->where('TrangThai', 1)
            ->where('ThoiGianBatDau', '<=', $currentDate)
            ->where('ThoiGianKetThuc', '>=', $currentDate)
            ->get();
        $allChiTietCTGG = ChuongTrinhGiamGiaSP::orderBy('MaCTGGSP', 'DESC')->get();
        $sanPhamNoiBat = SanPham::orderBy('MaSanPham', 'ASC')->take(20)->whereNotIn('SoLuongHienTai', ['', 0])->get();

        // SEO
        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.home')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allDanhGia', 'allCTGG', 'allChiTietCTGG', 'sanPhamNoiBat'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiDanhMucCha(Request $request, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $allDanhMucCon = '';

        $danhMuc = DanhMuc::where('MaDanhMuc', $MaDanhMuc)->first();
        $meta_desc = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $meta_keywords = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $meta_title = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                    $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
                }
                return view('pages.SanPham.DanhMuc.HienThiDanhMucCha')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
            }
        }

        return view('pages.SanPham.DanhMuc.HienThiDanhMucCha')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiDanhMucCon(Request $request, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->where('TrangThai', '1')->paginate(12);
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();
        $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();

        $danhMuc = DanhMuc::where('MaDanhMuc', $MaDanhMuc)->first();
        $meta_desc = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $meta_keywords = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $meta_title = 'Sản phẩm thuộc danh mục '.$danhMuc['TenDanhMuc'];
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.SanPham.DanhMuc.HienThiDanhMucCon')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allDanhMucTSKT', 'allTSKT', 'allTHDM', 'MaDanhMuc'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiSanPhamTheoTSKT(Request $request, $MaTSKT, $MaDanhMuc){
        $danhMucCha = $MaDanhMuc;
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $ThongSoKyThuat = ThongSoKyThuat::where('MaTSKT', $MaTSKT)->first();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $sanPhamThuocTSKT = SanPhamTSKT::orderBy('MaTSKT', 'DESC')->where('MaTSKT', $MaTSKT)->paginate('20');
        $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();

        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.SanPham.ThongSoKyThuat.HienThiSanPhamTheoTSKT')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'sanPhamThuocTSKT', 'allDanhMucTSKT', 'allTSKT', 'allTHDM', 'MaDanhMuc', 'danhMucCha', 'ThongSoKyThuat'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));;
    }

    public function HienThiSanPhamTheoTH(Request $request, $MaThuongHieu, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $thuongHieu = ThuongHieu::where('MaThuongHieu', $MaThuongHieu)->first();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $allDanhMucCon = '';
        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->where('MaThuongHieu', $MaThuongHieu)->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaThuongHieu', $MaThuongHieu)->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->where('MaThuongHieu', $MaThuongHieu)->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                    $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->where('MaThuongHieu', $MaThuongHieu)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
                }
                return view('pages.SanPham.DanhMuc.HienThiDanhMucCha')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
            }
        }

        return view('pages.SanPham.ThuongHieu.HienThiSanPhamTheoTH')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allDanhMucTSKT', 'allTSKT', 'allTHDM', 'MaDanhMuc', 'thuongHieu'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function ChiTietSanPham(Request $request, $MaSanPham){
        $chiTietSanPham = SanPham::where('MaSanPham', $MaSanPham)->first();
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allSanPhamTSKT = SanPhamTSKT::orderBy('MaTSKTSP', 'DESC')->where('MaSanPham', $MaSanPham)->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->where('TrangThai', 1)->get();
        $allTaiKhoan = TaiKhoan::orderBy('MaTaiKhoan', 'DESC')->get();
        $rating = DanhGia::where('MaSanPham', $MaSanPham)->avg('SoSao');
        $rating = round($rating);
        $sanPhamLienQuan = SanPham::where('MaDanhMuc', $chiTietSanPham->MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])
        ->where('MaThuongHieu', $chiTietSanPham->MaThuongHieu)->whereNotIn('MaSanPham', [$MaSanPham])->take(4)->get();

        $meta_desc = 'Chi tiết sản phẩm '.$chiTietSanPham['TenSanPham'];
        $meta_keywords = 'Chi tiết sản phẩm '.$chiTietSanPham['TenSanPham'];
        $meta_title = 'Chi tiết sản phẩm '.$chiTietSanPham['TenSanPham'];
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/SanPham/'.$chiTietSanPham['HinhAnh'];

        return view('pages.SanPham.ChiTietSanPham')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'chiTietSanPham', 'allSanPhamTSKT', 'allDanhGia', 'allTaiKhoan'))
        ->with(compact('rating', 'sanPhamLienQuan', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function TimKiem(Request $request){
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'ASC')->where('TrangThai', '1')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'ASC')->where('TrangThai', 1)->get();
        $keywords = $request->keywords_submit;

        if($keywords == ''){
            return Redirect::to('/');
        }

        $allSanPham = SanPham::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->where('TenSanPham', 'like', '%'.$keywords.'%')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
        $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('TenSanPham', 'like', '%'.$keywords.'%')->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();;

        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.SanPham.timkiem')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allDanhGia', 'sanPhamNoiBat'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function ThanhToan(Request $request){
        $allThanhPho = TinhThanhPho::orderBy('MaThanhPho', 'ASC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allSanPham = SanPham::orderBy('MaDanhMuc', 'DESC')->where('TrangThai', '1')->whereNotIn('SoLuongHienTai', ['', 0])->paginate('20');

        $meta_desc = "Trang thanh toán sản phẩm";
        $meta_keywords = "Trang thanh toán sản phẩm";
        $meta_title = "Trang thanh toán sản phẩm";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.ThanhToan.ThanhToan')->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allThanhPho'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function thongTinTaiKhoan(Request $request){
        $user = session(('user'));
        if ($user && isset($user['TenTaiKhoan'])) {
            $TenTaiKhoan = $user['TenTaiKhoan'];
            $tk = DB::select("SELECT * FROM tbl_taikhoan WHERE tbl_taikhoan.TenTaiKhoan = ?", [$TenTaiKhoan]);
        //    dd($tk[0]->BacNguoiDung);
            $phieuGiamGia = PhieuGiamGia::where('BacNguoiDung', $tk[0]->BacNguoiDung)->orderBy('ThoiGianBatDau', 'DESC')->paginate('4');
            // dd($phieuGiamGia[0]);
            $donHang = DonHang::where('Email', $tk[0]->Email)->get();

        //    dd($donHang);
        }

        $meta_desc = "Trang thông tin tài khoản";
        $meta_keywords = "Trang thông tin tài khoản";
        $meta_title = "Trang thông tin tài khoản";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';
//        dd($phieuGiamGia);
        return view('auth.trangCaNhan')->with(compact( 'tk', 'phieuGiamGia', 'donHang'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));;
    }

    public function xemCTDH(Request $request, $order_code)
    {
        $meta_desc = "Trang thông tin đơn hàng";
        $meta_keywords = "Trang thông đơn hàng";
        $meta_title = "Trang thông tin đơn hàng";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        $allDonHang = DonHang::where('order_code', $order_code)->first();
        $allChiTietDonHang = ChiTietDonHang::orderBy('MaCTDH', 'DESC')->where('order_code', $order_code)->get();
        return view('pages.DonHang.chiTietDonHang')
            ->with(compact('allChiTietDonHang', 'allDonHang', 'meta_title', 'meta_keywords', 'image_og', 'meta_desc', 'url_canonical'));
    }

    public function TrangKhachHangDangNhap(){
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allSanPham = SanPham::orderBy('MaDanhMuc', 'DESC')->where('TrangThai', '1')->paginate('20');
        return view('pages.TaiKhoan.login')->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham'));
    }

    public function KhachHangDangNhap(Request $request){
        $data = $request->all();
        $Email = $data['Email'];
        $MatKhau = md5($data['MatKhau']);
        $login = TaiKhoan::where('Email', $Email)->where('MatKhau', $MatKhau)->first();
        $isAdmin = 0;
        $phanQuyenNguoiDung = PhanQuyenNguoiDung::orderBy('MaPQND', 'DESC')->get();
        foreach($phanQuyenNguoiDung as $key => $value){
            if($value->MaTaiKhoan == $login->MaTaiKhoan){
                $isAdmin++;
            }
        }
        if($isAdmin > 1){
            Session::put('isAdmin', $isAdmin);
        }
        if($login){
            $login_count = $login->count();
            if($login_count){
                Session::put('MaTaiKhoan', $login->MaTaiKhoan);
                return Redirect::to('/');
            }
        }else{
            Session::put('status', 'Mật khẩu hoặc tài khoản không đúng. Vui lòng đăng nhập lại');
            return Redirect::to('/TrangKhachHangDangNhap');
        }
    }

    public function KhachHangDangXuat(){
        Session::put('TenTaiKhoan', null);
        Session::put('MaTaiKhoan', null);
        Session::put('isAdmin', null);
        return Redirect::to('/');
    }

    public function HienThiBaiViet(Request $request){
        $allBaiViet = BaiViet::orderBy('MaBaiViet', 'DESC')->orderBy('MaDanhMucBV', 'DESC')->paginate(15);
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->where('TrangThai', '1')->get();

        $meta_desc = "Trang thống kê bài viết";
        $meta_keywords = "Trang thống kê bài viết";
        $meta_title = "Trang thống kê bài viết";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.BaiViet.BaiViet')->with(compact('allBaiViet', 'allDanhMucBV'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiBaiVietTheoDMBV(Request $request, $MaDanhMucBV){
        $allBaiViet = BaiViet::orderBy('MaBaiViet', 'DESC')->where('MaDanhMucBV', $MaDanhMucBV)
        ->where('TrangThai', 1)->paginate(15);
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->where('TrangThai', '1')->get();

        $danhMucBV = DanhMucBaiViet::where('MaDanhMucBV', $MaDanhMucBV)->first();
        $meta_desc = "Bài viết thuộc danh mục ".$danhMucBV['TenDanhMucBV'];
        $meta_keywords = "Bài viết thuộc danh mục ".$danhMucBV['TenDanhMucBV'];
        $meta_title = "Bài viết thuộc danh mục ".$danhMucBV['TenDanhMucBV'];
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.BaiViet.BaiVietTheoDMBV')->with(compact('allBaiViet', 'allDanhMucBV'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function ChiTietBaiViet(Request $request, $MaBaiViet){
        $baiViet = BaiViet::where('MaBaiViet', $MaBaiViet)->first();
        $allDanhMucBV = DanhMucBaiViet::orderBy('MaDanhMucBV', 'DESC')->where('TrangThai', '1')->get();
        $allBinhLuan = BinhLuan::orderBy('MaBinhLuan', 'DESC')->where('MaBaiViet', $MaBaiViet)->where('TrangThai', 1)->get();
        $allTaiKhoan = TaiKhoan::orderBy('MaTaiKhoan', 'DESC')->get();

        $meta_desc = "Chi tiết bài viết ".$baiViet['TenBaiViet'];
        $meta_keywords = "Chi tiết bài viết ".$baiViet['TenBaiViet'];
        $meta_title = "Chi tiết bài viết ".$baiViet['TenBaiViet'];
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        return view('pages.BaiViet.ChiTietBaiViet')
        ->with(compact('baiViet', 'allDanhMucBV', 'allBinhLuan', 'allTaiKhoan'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));;
    }

    public function HienThiSanPhamTheoGiaTang(Request $request, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        $allDanhMucCon = '';
        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->where('TrangThai', '1')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('GiaSanPham', 'DESC')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                    $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('GiaSanPham', 'DESC')->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
                }
                return view('pages.SanPham.BoLoc.GiaThapDenCao')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
            }
        }

        return view('pages.SanPham.BoLoc.GiaThapDenCao')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiSanPhamTheoGiaGiam(Request $request, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $allDanhMucCon = '';
        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::orderBy('GiaSanPham', 'ASC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->where('TrangThai', '1')->paginate(20);
                $sanPhamNoiBat = SanPham::orderBy('GiaSanPham', 'ASC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('GiaSanPham', 'ASC')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                    $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('GiaSanPham', 'ASC')->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
                }
                return view('pages.SanPham.BoLoc.GiaCaoDenThap')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
            }
        }

        return view('pages.SanPham.BoLoc.GiaCaoDenThap')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function HienThiSanPhamTheoSoLuongBan(Request $request, $MaDanhMuc){
        $allThuongHieu = ThuongHieu::orderBy('MaThuongHieu', 'DESC')->where('TrangThai', '1')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'ASC')->where('TrangThai', '1')->get();
        $allTHDM = ThuongHieuDanhMuc::orderBy('MaTHDM', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allDanhMucTSKT = DanhMucTSKT::orderBy('MaDMTSKT', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->get();
        $allTSKT = ThongSoKyThuat::orderBy('MaTSKT', 'DESC')->get();
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();

        $allDanhMucCon = '';
        $meta_desc = "Chuyên bán những sản phẩm điện tử chất lượng cao, giá cả hợp lý";
        $meta_keywords = "Sản phẩm gia dụng, thiết bị văn phòng, đồ dùng cá nhân";
        $meta_title = "Electronic shop chuyên bán sản phẩm điện tử";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::orderBy('SoLuongBan', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->where('TrangThai', '1')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                $sanPhamNoiBat = SanPham::orderBy('SoLuongBan', 'DESC')->where('MaDanhMuc', $MaDanhMuc)->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('SoLuongBan', 'DESC')->whereNotIn('SoLuongHienTai', ['', 0])->paginate(20);
                    $sanPhamNoiBat = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->orderBy('SoLuongBan', 'DESC')->whereNotIn('SoLuongHienTai', ['', 0])->take(12)->get();
                }
                return view('pages.SanPham.BoLoc.GiaCaoDenThap')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
            }
        }

        return view('pages.SanPham.BoLoc.HienThiSanPhamBanChay')
        ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
        ->with(compact('allDanhGia', 'sanPhamNoiBat', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    }

    public function product_tabs(Request $request){
        $data = $request->all();
        $output = '';
        $allDanhGia = DanhGia::orderBy('MaDanhGia', 'DESC')->get();
        $allDanhMuc = DanhMuc::orderBy('MaDanhMuc', 'DESC')->get();
        $allDanhMucCon = '';
        foreach($allDanhMuc as $key => $valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $data['MaDanhMuc']){
                $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $data['MaDanhMuc'])->whereNotIn('SoLuongHienTai', ['', 0])->take(5)->get();
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->whereNotIn('SoLuongHienTai', ['', 0])->take(5)->get();
                }
                $output.='
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tshirt">';
                    foreach($allSanPham as $key => $sanPham){
                    $output.='
                    <div class="col-sm-15">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <form>
                                        '. csrf_field() .'
                                        <input type="hidden" value="'. $sanPham->MaSanPham .'" class="cart_product_id_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->TenSanPham .'" class="cart_product_name_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->HinhAnh .'" class="cart_product_image_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->GiaSanPham .'" class="cart_product_price_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->ChieuCao .'" class="cart_product_height_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->ChieuNgang .'" class="cart_product_width_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->ChieuDay .'" class="cart_product_thick_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->CanNang .'" class="cart_product_weight_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->ThoiGianBaoHanh .'" class="cart_product_guarantee_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="'. $sanPham->SoLuongHienTai .'" class="cart_product_quantity_'. $sanPham->MaSanPham .'">
                                        <input type="hidden" value="1" class="cart_product_qty_'. $sanPham->MaSanPham .'">
                                        <a href="'. route('/ChiTietSanPham', $sanPham->MaSanPham) .'">
                                            <img src="'. asset('upload/SanPham/'.$sanPham->HinhAnh) .'" alt="" />
                                            <p class="product-name">'. $sanPham->TenSanPham .'</p>
                                            <h2 class="">'.  number_format($sanPham->GiaSanPham,0,',','.').'₫'  .'</h2>
                                            <p class="vote-txt">
                                        ';
                                        $count = 0;
                                        $tongSoSao = 0;
                                            foreach($allDanhGia as $key => $danhGia){
                                                if($danhGia->MaSanPham == $sanPham->MaSanPham){
                                                    $count++;
                                                    $tongSoSao += $danhGia->SoSao;
                                                }
                                            }
                                            if($count > 0){
                                                $tongSoSao = $tongSoSao/$count;
                                                $output.='
                                                <b>'. number_format($tongSoSao, 1) .'</b>
                                                <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                <b>('. $count .')</b>
                                                ';
                                            }elseif($count == 0){
                                                $output.='
                                                <b>'. number_format($tongSoSao, 1) .'</b>
                                                <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                <b>(0)</b>
                                                ';
                                            }
                                    $output.='
                                            </p>
                                        </a>
                                        <button type="button" class="btn btn-default add-to-cart ThemGioHang"
                                        data-id_product="'. $sanPham->MaSanPham .'">
                                            <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        ';}
                $output.='</div>
                </div>
                ';
            }
        }

        $output.='
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tshirt">';
            foreach($allSanPham as $key => $sanPham){
            $output.='
            <div class="col-sm-15">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                '. csrf_field() .'
                                <input type="hidden" value="'. $sanPham->MaSanPham .'" class="cart_product_id_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->TenSanPham .'" class="cart_product_name_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->HinhAnh .'" class="cart_product_image_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->GiaSanPham .'" class="cart_product_price_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->ChieuCao .'" class="cart_product_height_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->ChieuNgang .'" class="cart_product_width_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->ChieuDay .'" class="cart_product_thick_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->CanNang .'" class="cart_product_weight_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->ThoiGianBaoHanh .'" class="cart_product_guarantee_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="'. $sanPham->SoLuongHienTai .'" class="cart_product_quantity_'. $sanPham->MaSanPham .'">
                                <input type="hidden" value="1" class="cart_product_qty_'. $sanPham->MaSanPham .'">
                                <a href="'. route('/ChiTietSanPham', $sanPham->MaSanPham) .'">
                                    <img src="'. asset('upload/SanPham/'.$sanPham->HinhAnh) .'" alt="" />
                                    <p class="product-name">'. $sanPham->TenSanPham .'</p>
                                    <h2 class="">'.  number_format($sanPham->GiaSanPham,0,',','.').'₫'  .'</h2>
                                    <p class="vote-txt">
                                ';
                                $count = 0;
                                $tongSoSao = 0;
                                    foreach($allDanhGia as $key => $danhGia){
                                        if($danhGia->MaSanPham == $sanPham->MaSanPham){
                                            $count++;
                                            $tongSoSao += $danhGia->SoSao;
                                        }
                                    }
                                    if($count > 0){
                                        $tongSoSao = $tongSoSao/$count;
                                        $output.='
                                        <b>'. number_format($tongSoSao, 1) .'</b>
                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                        <b>('. $count .')</b>
                                        ';
                                    }elseif($count == 0){
                                        $output.='
                                        <b>'. number_format($tongSoSao, 1) .'</b>
                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                        <b>(0)</b>
                                        ';
                                    }
                            $output.='
                                    </p>
                                </a>
                                <button type="button" class="btn btn-default add-to-cart ThemGioHang"
                                data-id_product="'. $sanPham->MaSanPham .'">
                                    <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                ';}
        $output.='</div>
        </div>
        ';

        return $output;
    }
}
