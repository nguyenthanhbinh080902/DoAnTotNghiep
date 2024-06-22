@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="review-payment">
            <h2>Giỏ hàng</h2>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td style="width: 25%" class="description">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td>Tiền vận chuyển</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    $total_after = 0;
                    $total_after_fee = 0;
                    $TySo = 0;
                    $TienVanChuyen = 0;
                    @endphp
                    @if (Session::get('cart') == true)
                        @foreach (Session::get('cart') as $key => $cart)
                        @php
                            $subtotal = $cart['GiaSanPham'] * $cart['SoLuong'];
                            $total += $subtotal;
                            $TySo = ($cart['ChieuCao'] * $cart['ChieuNgang'] * $cart['ChieuDay']) / 5000;
                            if ($cart['CanNang'] >= $TySo){
                                if($cart['CanNang'] <= 1){
                                    $TienVanChuyen = 0;
                                }elseif ($cart['CanNang'] > 1 && $cart['CanNang'] <= 5){
                                    $TienVanChuyen = $cart['CanNang'] * 2500;
                                }elseif ($cart['CanNang'] > 5 && $cart['CanNang'] <= 10){
                                    $TienVanChuyen = $cart['CanNang'] * 3000;
                                }elseif ($cart['CanNang'] > 10){
                                    $TienVanChuyen = $cart['CanNang'] * 4000;
                                }
                            }elseif ($cart['CanNang'] < $TySo){
                                if($TySo <= 1){
                                    $TienVanChuyen = $TySo * 1500;
                                }elseif ($TySo > 1 && $TySo <= 5){
                                    $TienVanChuyen = $TySo * 2500;
                                }elseif ($TySo > 5 && $TySo <= 10){
                                    $TienVanChuyen = $TySo * 3000;
                                }elseif ($TySo > 10){
                                    $TienVanChuyen = $TySo * 4000;
                                }
                            }
                            $total_after_fee += $TienVanChuyen * $cart['SoLuong'];
                        @endphp
                        <tr>
                            <td class="HinhAnh">
                                <a href="{{ route('/ChiTietSanPham', $cart['MaSanPham']) }}"><img src="{{ asset('upload/SanPham/'.$cart['HinhAnh']) }}" style="width: 120px; height:90px" alt=""></a>
                            </td>
                            <td class="TenSanPham">
                                <h4><a href=""></a></h4>
                                <p>{{ $cart['TenSanPham'] }}</p>
                            </td>
                            <td class="GiaSanPham">
                                <p class="cart_total_price">{{ number_format($cart['GiaSanPham'], 0, '', '.') }} đ</p>
                            </td>
                            <td class="SoLuong">
                                {{-- <div class="cart_quantity_button">
                                    <a class="cart_quantity_up updateCartItem qtyPlus" 
                                    data-cartid="{{ $cart['session_id'] }}" data-soluonghientai="{{ $cart['SoLuongHienTai'] }}" data-qty="{{ $cart['SoLuong'] }}"> + </a>
                                    <input class="cart_quantity_input " type="text" name="quantity" 
                                    value="{{ $cart['SoLuong'] }}" autocomplete="off" size="2" 
                                    data-min="1" data-max="1000">
                                    <a class="cart_quantity_down updateCartItem qtyMinus" 
                                    data-cartid="{{ $cart['session_id'] }}" data-soluonghientai="{{ $cart['SoLuongHienTai'] }}" data-qty="{{ $cart['SoLuong'] }}"> - </a>
                                </div> --}}
								<div class="cart_quantity_button">
                                    <form action="{{ route('/ThayDoiSoLuongSanPham', [$cart['session_id']]) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="number" min="1" value="{{ $cart['SoLuong'] }}" style="width: 100px" name="SoLuongSanPham">
                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                    </form>
								</div>
                            </td> 
                            <td class="cart_total">
                                <p class="cart_total_price">{{ number_format(($TienVanChuyen * $cart['SoLuong']), 0, '', '.') }} đ</p>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">{{ number_format($subtotal, 0, '', '.') }} đ</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{ route('/XoaSanPhamTrongGioHang', $cart['session_id']) }}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>                         
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="4">
                            {{-- <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"> --}}
                        </td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Tiền của giỏ hàng</td>
                                    <td>{{ number_format($total, 0, '', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td>Tiền từ phiếu giảm giá</td>
                                    <td>
                                        @if (Session::get('PhieuGiamGia'))
                                            @php
                                                $phieuGiamGia = Session::get('PhieuGiamGia');
                                            @endphp
                                            @if ($phieuGiamGia['DonViTinh'] == 1)
                                                {{ number_format($phieuGiamGia['TriGia'], 0,',','.') }}đ
                                                @php
                                                    $total_after_coupon = $phieuGiamGia['TriGia'];
                                                @endphp
                                            @elseif ($phieuGiamGia['DonViTinh'] == 2)
                                                @php
                                                    $phanTramGiam = (int) $phieuGiamGia['TriGia'];
                                                    $tienGiam = ($total*$phanTramGiam)/100;
                                                    $total_after_coupon = $tienGiam;
                                                @endphp
                                                {{ $phieuGiamGia['TriGia'] }}% | {{ number_format($tienGiam, 0,',','.') }} đ
                                            @endif
                                        @else
                                            0 đ
                                        @endif
                                    </td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Tiền giao hàng</td>
                                    <td>
                                        @if (Session::get('PhiGiaoHang'))
                                            @php
                                                $PhiGiaoHang = Session::get('PhiGiaoHang');
                                                $total_after_fee += $PhiGiaoHang['SoTien'];
                                            @endphp
                                            {{ number_format($total_after_fee, 0,',','.') }} đ
                                        @elseif (!Session::get('PhiGiaoHang'))
                                            {{ number_format($total_after_fee, 0,',','.') }} đ
                                        @endif
                                    </td>										
                                </tr>
                                <tr>
                                    <td>
                                        <p class="cart_total_price">Tổng tiền</p>
                                    </td>
                                    <td>
                                        <p class="cart_total_price">
                                        @php
                                            if(Empty(Session('PhieuGiamGia')) && Empty(Session('PhiGiaoHang'))){
                                                $total_after = $total + $total_after_fee;
                                                echo number_format($total_after,0,',','.').'đ';
                                            }elseif(Empty(Session('PhieuGiamGia')) && Session('PhiGiaoHang')){
                                                $total_after = $total + $total_after_fee;
                                                echo number_format($total_after,0,',','.').'đ';
                                            }elseif (Session('PhieuGiamGia') && Empty(Session('PhiGiaoHang'))){
                                                $total_after = $total - $total_after_coupon + $total_after_fee;
                                                echo number_format($total_after,0,',','.').'đ';
                                            }elseif (Session('PhieuGiamGia') && Session('PhiGiaoHang')){
                                                $total_after = $total - $total_after_coupon + $total_after_fee;
                                                echo number_format($total_after,0,',','.').'đ';
                                            }
                                        @endphp
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="review-payment">
            <h2>Điền thông tin đặt hàng</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="shopper-informations">
            <div class="row">
                <form action="{{ route('/DatHang') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-sm-3">
                        <div class="shopper-info">
                            <p>Thông tin người nhận hàng</p>
                            <input type="text" name="TenNguoiNhan" value="{{old('TenNguoiNhan')}}" placeholder="Tên người nhận">
                            <input type="text" name="SoDienThoai" value="{{old('SoDienThoai')}}" placeholder="Số điện thoại">
                            <input type="text" name="DiaChi" value="{{old('DiaChi')}}" placeholder="Địa chỉ">
                            <input type="hidden" name="PhiGiaoHang" value="{{ $total_after_fee }}">
                            <button class="btn btn-primary DatHang" type="submit" name="DatHang">Đặt hàng</button>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="order-message">
                            <p>Ghi chú</p>
                            <textarea class="GhiChu" name="GhiChu" placeholder="Điền ghi chú của bạn để nhân viên có thể làm theo yêu cầu" rows="16"></textarea>
                        </div>	
                    </div>
                </form>
                <div class="col-sm-6 clearfix">
                    <div class="bill-to">
                        <p>Phiếu giảm giá và tiền giao hàng</p>
                        <div class="form-one">
                            <form action="{{ Route('/ApDungPhieuGiamGia') }}" method="POST">
                                {{ csrf_field() }}  
                                <input type="text" class="MaCode" name="MaCode" placeholder="Điền Mã Code">
                                <button type="submit" name="ThemSanPham" class="btn btn-primary">Áp dụng mã giảm giá</button>
                            </form>
                            <a class="btn btn-primary" href="{{ Route('/HuyPhieuGiamGia') }}">Xóa phiếu giảm giá</a>
                        </div>
                        <div class="form-two">
                            <form>
                                {{ csrf_field() }}
                                <select name="MaThanhPho" id="MaThanhPho" class="ChonDiaDiem MaThanhPho">
                                    <option>-- Thành phố / Tỉnh --</option>
                                    @foreach ($allThanhPho as $key => $thanhPho)
                                        <option value="{{ $thanhPho->MaThanhPho }}" >{{ $thanhPho->TenThanhPho }}</option>
                                    @endforeach
                                </select>
                                <select name="MaQuanHuyen" id="MaQuanHuyen" class="ChonDiaDiem MaQuanHuyen">
                                    <option>-- Quận / Huyện --</option>
                                </select>
                                <select name="MaXaPhuong" id="MaXaPhuong" class="MaXaPhuong">
                                    <option>-- Xã / Phường --</option>
                                </select>
                            </form>
                            <a class="btn btn-primary TinhPhiGiaoHang" name="TinhPhiGiaoHang" >Tính tiền giao hàng</a>
                            <a class="btn btn-primary" href="{{ route('/HuyPhiGiaoHang') }}">Xóa tiền giao hàng</a>
                        </div>
                    </div>
                </div>				
            </div>
        </div>
    </div>
</section>
@endsection