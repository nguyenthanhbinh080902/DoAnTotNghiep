<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Session;
use App\Models\TaiKhoan;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use App\Models\PhiGiaoHang;
use App\Models\TinhThanhPho;
use App\Models\PhieuGiamGia;
use App\Models\PhieuGiamGiaNguoiDung;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\PhieuBaoHanh;
use App\Models\ChiTietPhieuBaoHanh;
use App\Models\GiaoHang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class GioHangController extends Controller
{
    public function ThemGioHang(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if($cart == true){
            $is_avaiable = 0;
            foreach($cart as $key => $value){
                if($value['MaSanPham'] == $data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'MaSanPham' => $data['cart_product_id'],
                    'TenSanPham' => $data['cart_product_name'],
                    'HinhAnh' => $data['cart_product_image'],
                    'SoLuong' => $data['cart_product_qty'],
                    'GiaSanPham' => $data['cart_product_price'],
                    'ChieuCao' => $data['cart_product_height'],
                    'ChieuNgang' => $data['cart_product_width'],
                    'ChieuDay' => $data['cart_product_thick'],
                    'CanNang' => $data['cart_product_weight'],
                    'ThoiGianBaoHanh' => $data['cart_product_guarantee'],
                    'SoLuongHienTai' => $data['cart_product_quantity'],
                );
                Session::put('cart', $cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'MaSanPham' => $data['cart_product_id'],
                'TenSanPham' => $data['cart_product_name'],
                'HinhAnh' => $data['cart_product_image'],
                'SoLuong' => $data['cart_product_qty'],
                'GiaSanPham' => $data['cart_product_price'],
                'ChieuCao' => $data['cart_product_height'],
                'ChieuNgang' => $data['cart_product_width'],
                'ChieuDay' => $data['cart_product_thick'],
                'CanNang' => $data['cart_product_weight'],
                'ThoiGianBaoHanh' => $data['cart_product_guarantee'],
                'SoLuongHienTai' => $data['cart_product_quantity'],
            );
        }
        Session::put('cart', $cart);
        Session::save();
    }

    public function HienThiGioHang(Request $request){

        $meta_desc = "Trang thanh toán sản phẩm"; 
        $meta_keywords = "Trang thanh toán sản phẩm";
        $meta_title = "Trang thanh toán sản phẩm";
        $url_canonical = $request->url();
        $image_og = $url_canonical.'/upload/logo.jpg';

        $allThanhPho = TinhThanhPho::orderBy('MaThanhPho', 'ASC')->get();

        return view('pages.ThanhToan.ThanhToan')->with(compact('allThanhPho'))
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'image_og'));
    } 

    public function XoaSanPhamTrongGioHang($session_id){
        $cart = Session::get('cart');
        if($cart == true){
            foreach($cart as $key => $value){
                if($value['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return Redirect()->back()->with('message', 'Xóa sản phẩm khỏi giỏ hàng thành công');
        }else{
            return Redirect()->back()->with('message', 'Xóa sản phẩm khỏi giỏ hàng thất bại');
        }
    }

    public function ThayDoiSoLuong(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
        if($cart == true){
            foreach($cart as $session => $value){
                if($value['session_id'] == $data['cartid']){
                    $cart[$session]['SoLuong'] =  $data['qty'];
                }
            }
            Session::put('cart', $cart);
            return Redirect()->back();
        }else{
            return Redirect()->back();
        }
    }

    public function XoaGioHang(){
        $cart = Session::get('cart');
        if($cart){
            Session::forget('cart');
            return Redirect()->back()->with('message', 'Xóa toàn bộ giỏ hàng'); 
        }else{
            return Redirect()->back()->with('message', 'Giỏ hàng đang trống'); 
        }
    }

    public function TinhPhiGiaoHang(Request $request){
        $data = $request->all();
        if($data['MaThanhPho']){
            $phiGiaoHang = PhiGiaoHang::where('MaThanhPho', $data['MaThanhPho'])->where('MaQuanHuyen', $data['MaQuanHuyen'])->where('MaXaPhuong', $data['MaXaPhuong'])->get();
            if($phiGiaoHang){
                if($phiGiaoHang->isNotEmpty()){
                    foreach($phiGiaoHang as $key => $value){
                        $array = array(
                            'MaPhiGiaoHang' => $value->MaPhiGiaoHang,
                            'SoTien' => $value->SoTien,
                        );
                        Session::put('PhiGiaoHang', $array);
                        Session::save();
                    }
                }else{
                    return Redirect()->back()->with('message', 'Chọn địa điểm khác để giao hàng'); 
                }
            }
        }else{
            return Redirect()->back()->with('message', 'Hãy chọn thành phố khác'); 
        }
    }

    public function HuyPhiGiaoHang(){
        $phiGiaoHang = Session::get('PhiGiaoHang');
        if($phiGiaoHang){
            Session::forget('PhiGiaoHang');
            return Redirect()->back()->with('message', 'Xóa Phí giao hàng thành công'); 
        }else{
            return Redirect()->back()->with('message', 'Chưa tính phí giao hàng'); 
        }
    }

    public function ApDungPhieuGiamGia(Request $request){
        $data = $request->all();
        if($data['MaCode'] == null){
            return Redirect()->back()->with('error', 'Bạn hãy điền Mã code của phiếu giảm giá'); 
        }elseif(Empty(Session('cart'))){
            return Redirect()->back()->with('error', 'Bạn hãy thêm sản phẩm vào giỏ hàng'); 
        }elseif(Empty(Session('user'))){
            return Redirect()->back()->with('error', 'Bạn hãy đăng nhập để dùng phiếu giảm giá này'); 
        }else{
            $user = Session::get('user');
            $phieuGiamGia = PhieuGiamGia::where('MaCode', $data['MaCode'])->first();
            $taiKhoan = TaiKhoan::where('Email', $user['Email'])->first();
            if($phieuGiamGia){
                $array = array(
                    'MaGiamGia' => $phieuGiamGia->MaGiamGia,
                    'MaCode' => $phieuGiamGia->MaCode,
                    'DonViTinh' => $phieuGiamGia->DonViTinh,
                    'TriGia' => $phieuGiamGia->TriGia,
                );
                Session::put('PhieuGiamGia', $array);
                return Redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
            }else{
                return Redirect()->back()->with('error', 'Không tồn tại phiếu giảm giá này');
            }
        }
    }

    public function HuyPhieuGiamGia(){
        $phieuGiamGia = Session::get('PhieuGiamGia');
        if($phieuGiamGia){
            Session::forget('PhieuGiamGia');
            return Redirect()->back()->with('message', 'Xóa Phiếu giảm giá thành công'); 
        }else{
            return Redirect()->back()->with('message', 'Chưa áp dụng phiếu giảm giá nào'); 
        }
    }

    public function DatHang(Request $request){
        if(Empty(Session('cart'))){
            return Redirect()->back()->with('error', 'Bạn hãy thêm sản phẩm vào giỏ hàng trước khi thanh toán'); 
        }elseif(Empty(Session('user'))){
            return Redirect()->back()->with('error', 'Bạn hãy đăng nhập để có thể thực hiện thanh toán'); 
        }elseif(Empty(Session('PhiGiaoHang'))){
            return Redirect()->back()->with('error', 'Bạn hãy chọn địa điểm để tính tiền giao hàng'); 
        }else{
            // $gioHangSession = Session::get('cart');
            // $sanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
            // foreach($sanPham as $key => $value){
            //     foreach($gioHangSession as $key => $gioHang){
            //         if($value->MaSanPham == $gioHang['MaSanPham']){
            //             if($value->SoLuongHienTai < $gioHang['SoLuong']){
            //                 return Redirect()->back()->with('error', 'Sản phẩm '.$value->TenSanPham.' không đủ số lượng so với đơn hàng của bạn'); 
            //             }

            //         }
            //     }
            // }

            // $data = $request->validate([
            //     'TenNguoiNhan' => 'required',
            //     'SoDienThoai' => 'required',
            //     'DiaChi' => 'required',
            //     'GhiChu' => '',
            //     'PhiGiaoHang' => '',
            // ],
            // [
            //     'TenNguoiNhan.required' => 'Bạn chưa điền tên người nhận hàng',
            //     'SoDienThoai.required' => 'Bạn chưa điền số điện thoại',
            //     'DiaChi.required' => 'Bạn chưa điền địa chỉ giao hàng',
            // ]);
            // $phieuGiamGiaSession = Session::get('PhieuGiamGia');
            // $taiKhoanSession = Session::get('user');
            // $phiGiaoHangSession = Session::get('PhiGiaoHang');

            // $phiGiaoHang = PhiGiaoHang::where('MaPhiGiaoHang', $phiGiaoHangSession['MaPhiGiaoHang'])->first();
            // $diaChiGiaoHang = $data['DiaChi'].' '.$phiGiaoHang->XaPhuongThiTran->TenXaPhuong.' '.
            // $phiGiaoHang->QuanHuyen->TenQuanHuyen.' '.$phiGiaoHang->TinhThanhPho->TenThanhPho;
            // $giaoHang = new GiaoHang;
            // $giaoHang->TenNguoiNhan = $data['TenNguoiNhan'];
            // $giaoHang->DiaChi = $diaChiGiaoHang;
            // $giaoHang->TienGiaoHang = $data['PhiGiaoHang'];
            // $giaoHang->SoDienThoai = $data['SoDienThoai'];
            // $giaoHang->GhiChu = $data['GhiChu'];
            // $giaoHang->save();
            // $MaGiaoHang = $giaoHang->MaGiaoHang;

            // $thanhToan_code = substr(md5(microtime()),rand(0,26),5);

            // $donHang = new DonHang;
            // $donHang->Email = $taiKhoanSession['Email'];
            // $donHang->MaGiaoHang = $MaGiaoHang;
            // $donHang->order_code = $thanhToan_code;
            // if(Empty($phieuGiamGiaSession)){
            //     $donHang->MaGiamGia = null;
            // }else{
            //     $donHang->MaGiamGia = $phieuGiamGiaSession['MaGiamGia'];
                
            // }
            // $donHang->TrangThai = 1;
            // date_default_timezone_set('Asia/Ho_Chi_Minh');
            // $donHang->ThoiGianTao = now();
            // $donHang->save();

            // foreach(Session('cart') as $key => $valueGioHang){
            //     $chiTietDonHang = new ChiTietDonHang;
            //     $chiTietDonHang->order_code = $thanhToan_code;
            //     $chiTietDonHang->MaSanPham = $valueGioHang['MaSanPham'];
            //     $chiTietDonHang->SoLuong = $valueGioHang['SoLuong'];
            //     $chiTietDonHang->GiaSanPham = $valueGioHang['GiaSanPham'];
            //     $chiTietDonHang->save();
            // }

            // $phieuBaoHanh = new PhieuBaoHanh();
            // $phieuBaoHanh->order_code = $thanhToan_code;
            // $phieuBaoHanh->TenKhachHang = $data['TenNguoiNhan'];
            // $phieuBaoHanh->SoDienThoai = $data['SoDienThoai'];
            // $phieuBaoHanh->ThoiGianTao = now();
            // $phieuBaoHanh->save();

            // foreach(Session('cart') as $key => $valueGioHang){
            //     $chiTietPhieuBaoHanh = new ChiTietPhieuBaoHanh;
            //     $chiTietPhieuBaoHanh->order_code = $thanhToan_code;
            //     $chiTietPhieuBaoHanh->MaSanPham = $valueGioHang['MaSanPham'];
            //     $chiTietPhieuBaoHanh->SoLuong = $valueGioHang['SoLuong'];
            //     $chiTietPhieuBaoHanh->ThoiGianBaoHanh = $valueGioHang['ThoiGianBaoHanh'];
            //     $chiTietPhieuBaoHanh->ThoiGianBatDau = Carbon::now();
            //     $chiTietPhieuBaoHanh->ThoiGianKetThuc = Carbon::now()->addMonths($valueGioHang['ThoiGianBaoHanh']);
            //     $chiTietPhieuBaoHanh->save();
            // }

            // Session::forget('PhieuGiamGia');
            // Session::forget('PhiGiaoHang');
            // Session::forget('cart');
            // return Redirect()->back()->with('message', 'Đặt hành thành công'); 

            
        }
    }

    public function ThayDoiSoLuongSanPham(Request $request, $session_id){
        $data = $request->all();
        $soLuongMoi = $data['SoLuongSanPham'];
        $cart = Session::get('cart');
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
        foreach($cart as $session => $value){
            foreach($allSanPham as $key => $sanPham){
                if($value['session_id'] == $session_id && $value['MaSanPham'] == $sanPham->MaSanPham){    
                    if($sanPham->SoLuongHienTai >= $soLuongMoi){
                        $cart[$session]['SoLuong'] =  $soLuongMoi;
                        Session::put('cart', $cart);
                        return Redirect()->back()->with('message', 'Cập nhật số lượng sản phẩm thành công'); 
                    }else{
                        return Redirect()->back()->with('error', 'Số lượng hàng trong kho không đủ'); 
                    }
                }
            }
        }
    }
}

