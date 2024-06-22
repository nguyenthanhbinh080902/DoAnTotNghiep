<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\PhiGiaoHang;
use App\Models\PhieuGiamGia;
use App\Models\PhieuGiamGiaNguoiDung;
use App\Models\DonHang;
use App\Models\GiaoHang;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietPhieuNhap;
use App\Models\BaoCaoDoanhThu;
use App\Models\TichDiem;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Redirect;

class DonHangController extends Controller
{
    public function TrangLietKeDonHang(){
        $allDonHang = DonHang::orderBy('MaDonHang', 'DESC')->paginate(20);
        return view('admin.DonHang.LietKeDonHang')->with(compact('allDonHang'));
    }

    public function TrangChiTietDonHang($order_code){
        $allDonHang = DonHang::where('order_code', $order_code)->first();
        $allChiTietDonHang = ChiTietDonHang::orderBy('MaCTDH', 'DESC')->where('order_code', $order_code)->get();
        return view('admin.DonHang.TrangChiTietDonHang')->with(compact('allChiTietDonHang', 'allDonHang'));
    }

    public function XoaChiTietDonHang($MaCTDH, $order_code){
        $chiTietDonHang = ChiTietDonHang::orderBy('MaCTDH', 'DESC')->get();
        $count = 0;
        foreach($chiTietDonHang as $key => $valueCTDH){
            if($valueCTDH->order_code == $order_code){
                $count++;
            }
        }
        if($count == 1){
            return redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Hiện tại đơn hàng còn 1 sản phẩm nếu xóa đi đơn hàng sẽ trống!!!');
        }else{
            $deleteValue = ChiTietDonHang::find($MaCTDH);
            $deleteValue->delete();
            return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Xóa chi tiết đơn hàng thành công');
        }
    }

    public function XoaPhieuGiamGiaThuocDonHang($MaDonHang, $MaGiamGia){
        $donHang = DonHang::find($MaDonHang);
        $value = DonHang::where('MaDonHang', $MaDonHang)->first();
        $phieuGiamGiaND = PhieuGiamGiaNguoiDung::where('Email', $donHang['Email'])->where('MaGiamGia', $MaGiamGia)->first();
        $valuePGGND = PhieuGiamGiaNguoiDung::find($phieuGiamGiaND['MaPGGND']);
        $valuePGGND->SoLuong = $phieuGiamGiaND['SoLuong'] + 1;
        $valuePGGND->save();
        $donHang->MaGiamGia = null;
        $donHang->save();
        return Redirect()->route('/TrangChiTietDonHang', [$value->order_code])->with('status', 'Xóa phiếu giảm giảm giá '.$valuePGGND->PhieuGiamGia->TenPhieuGiamGia.' thành công');
    }

    public function TrangSuaThongTinGiaoHang($MaGiaoHang, $order_code){
        $giaoHang = GiaoHang::where('MaGiaoHang', $MaGiaoHang)->first();
        return view('admin.DonHang.ThayDoiThongTinGiaoHang')->with(compact('order_code', 'giaoHang'));
    }

    public function SuaThongTinGiaoHang($MaGiaoHang, $order_code, Request $request){
        $data = $request->validate([
            'TenNguoiNhan' => 'required|',
            'SoDienThoai' => 'required|',
            'DiaChi' => 'required',
            'GhiChu' => '',
        ],
        [
            'TenNguoiNhan.required' => 'Chưa điền tên người nhận',
            'SoDienThoai.required' => 'Chưa điền Số điện thoại',
            'DiaChi.required' => 'Chưa điền Địa chỉ giao hàng',
        ]);
        $giaoHang = GiaoHang::find($MaGiaoHang);
        $giaoHang->TenNguoiNhan = $data['TenNguoiNhan'];
        $giaoHang->SoDienThoai = $data['SoDienThoai'];
        $giaoHang->DiaChi = $data['DiaChi'];
        $giaoHang->GhiChu = $data['GhiChu'];
        $giaoHang->save();
        return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật thông tin giao hàng thành công');
    }

    public function XoaDonHang($MaDonHang, $order_code){
        $donHang = DonHang::find($MaDonHang);
        $phieuGiamGiaND = PhieuGiamGiaNguoiDung::where('Email', $donHang['Email'])->where('MaGiamGia', $donHang['MaGiamGia'])->first();
        $chiTietDonHang = ChiTietDonHang::find($order_code);
        if(Empty($phieuGiamGiaND)){
            $giaoHang = GiaoHang::find($donHang['MaGiaoHang']);
            $giaoHang->delete();
            $chiTietDonHang = ChiTietDonHang::where('order_code', $order_code)->get();
            foreach($chiTietDonHang as $key => $value){
                $chiTietDonHang->delete();
            }
            $donHang->delete();
            return Redirect()->route('/TrangLietKeDonHang')->with('status', 'Xóa đơn hàng thành công');
        }else{
            $valuePGGND = PhieuGiamGiaNguoiDung::find($phieuGiamGiaND['MaPGGND']);
            $valuePGGND->SoLuong = $phieuGiamGiaND['SoLuong'] + 1;
            $valuePGGND->save();
            $giaoHang = GiaoHang::find($donHang['MaGiaoHang']);
            $giaoHang->delete();
            $donHang->delete();
            $chiTietDonHang = ChiTietDonHang::where('order_code', $order_code)->delete();
            return Redirect()->route('/TrangLietKeDonHang')->with('status', 'Xóa đơn hàng thành công');
        }
    }

    public function SuaSoLuongSanPham($MaCTDH, $order_code, Request $request){
        $data = $request->all();
        $chiTietDonHang = ChiTietDonHang::where('MaCTDH', $MaCTDH)->first();
        $chiTietDonHang->SoLuong = $data['SoLuongSanPham'];
        $chiTietDonHang->save();
        return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật số lượng sản phẩm thành công');
    }

    public function SuaTrangThaiDonHang($MaDonHang, $order_code, Request $request){
        $data = $request->all();
        $allChiTietDonHang = ChiTietDonHang::where('order_code', $order_code)->get();
        $allSanPham = SanPham::orderBy('MaSanPham', 'DESC')->get();
        $donHang = DonHang::where('MaDonHang', $MaDonHang)->first();
        $allChiTietPhieuNhap = ChiTietPhieuNhap::orderBy('MaCTPN', 'DESC')->get();

        if($donHang['TrangThai'] == 1){
            if($data['TrangThaiDonHang'] != 2){
                return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật trạng thái đơn hàng thất bại');
            }elseif($data['TrangThaiDonHang'] == 2){
                foreach($allChiTietDonHang as $key => $chiTietDonHang){
                    foreach($allSanPham as $key => $sanPham){
                        if($sanPham->MaSanPham == $chiTietDonHang->MaSanPham){
                            SanPham::Where('MaSanPham', $chiTietDonHang->MaSanPham)->update(['SoLuongHienTai' => $sanPham->SoLuongHienTai - $chiTietDonHang->SoLuong]);
                            SanPham::Where('MaSanPham', $chiTietDonHang->MaSanPham)->update(['SoLuongBan' => $chiTietDonHang->SoLuong]);
                        }
                    }
                }
                DonHang::where('MaDonHang', $MaDonHang)->update(['TrangThai' => 2]);
                return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật trạng thái đơn hàng thành công');
            }
        }elseif($donHang['TrangThai'] == 2){
            if($data['TrangThaiDonHang'] == 1){
                return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật sai trạng thái đơn hàng');
            }elseif($data['TrangThaiDonHang'] == 3){
                //DonHang::where('MaDonHang', $MaDonHang)->update(['TrangThai' => 3]);
                // $doanhThu = 0;
                // $loiNhuan = 0;
                // $soLuongSanPham = 0;

                // foreach($allChiTietDonHang as $key => $value){
                //     $soLuongSanPham += $value['SoLuong'];
                //     if(Empty($donHang['MaGiamGia'])){
                //         $doanhThu += $value['SoLuong'] * $value['GiaSanPham'];
                //     }elseif($donHang['MaGiamGia']){
                //         $PhieuGiamGia = PhieuGiamGia::where('MaGiamGia', $donHang['MaGiamGia'])->first();
                //         $doanhThu += $value['SoLuong'] * $value['GiaSanPham'];
                //         if($PhieuGiamGia['DonViTinh'] == 1){
                //             $doanhThu = $doanhThu - $PhieuGiamGia['TriGia'];
                //         }elseif($PhieuGiamGia['DonViTinh'] == 2){
                //             $doanhThu = $doanhThu*(100 - $PhieuGiamGia['TriGia'])/100;
                //         }
                //     }
                // }

                // foreach($allChiTietDonHang as $key => $value1){
                //     foreach($allChiTietPhieuNhap as $key => $value2){
                //         if($value1['MaSanPham'] == $value2['MaSanPham']){
                //             $loiNhuan = $doanhThu - $value2['GiaSanPham']*$value1['SoLuong'];
                //         }else{
                //             $loiNhuan = $doanhThu*(100 - 80)/100;
                //         }
                //     }
                // }

                // date_default_timezone_set('Asia/Ho_Chi_Minh');
                // $today = now();
                // $today = date("Y-m-d", strtotime($donHang['ThoiGianTao']));
                // $baoCaoDoanhThu = BaoCaoDoanhThu::where('order_date', $today)->first();

                // // echo '<pre>';
                // // print_r($baoCaoDoanhThu);
                // // echo '</pre>';

                // if(Empty($baoCaoDoanhThu)){
                //     $themBCDT = new BaoCaoDoanhThu();
                //     $themBCDT->order_date = date("Y-m-d", strtotime($today));
                //     $themBCDT->sales = $doanhThu;
                //     $themBCDT->profit = $loiNhuan;
                //     $themBCDT->quantity = $soLuongSanPham;
                //     $themBCDT->total_order = 1;
                //     $themBCDT->save();
                // }elseif($baoCaoDoanhThu){
                //     $suaBCDT = BaoCaoDoanhThu::find($baoCaoDoanhThu['MaBCDT']);
                //     $suaBCDT->sales += $doanhThu;
                //     $suaBCDT->profit += $loiNhuan;
                //     $suaBCDT->quantity += $soLuongSanPham;
                //     $suaBCDT->total_order += 1;
                //     $suaBCDT->save();
                // }

                $tongDiem = 0;
                $donHang = DonHang::where('MaDonHang', $MaDonHang)->first();
                $allChiTietDonHang = ChiTietDonHang::orderBy('MaCTDH', 'DESC')->get();
                foreach($allChiTietDonHang as $key => $chiTietDonHang){
                    if($chiTietDonHang->order_code == $donHang['order_code']){
                        $tongDiem = $chiTietDonHang->SoLuong * $chiTietDonHang->GiaSanPham;
                    }
                }
                $tichDiem = TichDiem::where('Email', $donHang['Email'])->first();
                echo '<pre>';
                print_r($tichDiem['TongDiem'] + $tongDiem/5000);
                echo '</pre>';
                if(($tichDiem['TongDiem'] + $tongDiem/5000) > 3000 && ($tichDiem['TongDiem'] + $tongDiem/5000) < 6000 ){
                    TaiKhoan::where('Email', $donHang['Email'])->update(['BacNguoiDung' => 2]);
                }elseif(($tichDiem['TongDiem'] + $tongDiem/5000) > 10000){
                    TaiKhoan::where('Email', $donHang['Email'])->update(['BacNguoiDung' => 3]);
                }
            //return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật trạng thái đơn hàng thành công | Khách hàng thanh toán đơn hàng');
            }elseif($data['TrangThaiDonHang'] == 4){
                foreach($allChiTietDonHang as $key => $chiTietDonHang){
                    foreach($allSanPham as $key => $sanPham){
                        if($sanPham->MaSanPham == $chiTietDonHang->MaSanPham){
                            SanPham::Where('MaSanPham', $sanPham->MaSanPham)->update(['SoLuongHienTai' => $sanPham->SoLuongHienTai + $chiTietDonHang->SoLuong]);
                            SanPham::Where('MaSanPham', $sanPham->MaSanPham)->update(['SoLuongBan' => $sanPham->SoLuongBan - $chiTietDonHang->SoLuong]);
                        }
                    }
                }
                DonHang::where('MaDonHang', $MaDonHang)->update(['TrangThai' => 4]);
                return Redirect()->route('/TrangChiTietDonHang', [$order_code])->with('status', 'Cập nhật trạng thái đơn hàng thành công | Khách hàng không nhận hàng | Số lượng sản phẩm trả lại ban đầu');
            }
        }
    }

    public  function HuyDon(Request $request, $id)
    {
//        dd($id);
        $donHang = DonHang::find($id);
        $donHang->TrangThai = 0;
        $donHang->save();
        return Redirect()->route('/thong-tin-tai-khoan');
    }
}
