@extends('layout')
@section('content')
    @php
        $total = 0;
        $total_after = 0;
        $total_after_coupon = 0;
    @endphp
    <div class="container">

        <div class="">
            <div class="text-center" style="margin-bottom: 2%">
                <h2>Thông tin đơn hàng</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tên người nhận: </strong>{{ $allDonHang->GiaoHang->TenNguoiNhan }}</p>
                        <p><strong>Địa chỉ giao hàng: </strong>{{ $allDonHang->GiaoHang->DiaChi }}</p>
                        <p><strong>Số điện thoại: </strong>{{ $allDonHang->GiaoHang->SoDienThoai }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Số tiền: </strong>{{ number_format($allDonHang->GiaoHang->TienGiaoHang, 0, '', '.') }} đ</p>
                        <p><strong>Ghi chú: </strong>{{ $allDonHang->GiaoHang->GhiChu ?? 'Không có ghi chú nào' }}</p>
                    </div>
                </div>

{{--                thong tin san pham da mua--}}
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allChiTietDonHang as $key => $value)
                        @php
                            $total += $value->GiaSanPham * $value->SoLuong;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value->SanPham->TenSanPham }}</td>
                            <td><img src="{{ asset('upload/sanPham/'.$value->SanPham->HinhAnh) }}" height="100px" width="150px"></td>
                            <td>{{ $value->SoLuong }}</td>
                            <td>{{ number_format($value->GiaSanPham, 0, '', '.') }} đ</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" >
                            <div class="row">
                                <div class="col-lg-9"></div>
                                <div class="col-lg-3">

                                    <p>Tiền giỏ hàng: {{ number_format($total, 0,',','.').'đ' }}</p>
                                    <p>Phí ship: {{ number_format($allDonHang->GiaoHang->TienGiaoHang, 0,',','.').'đ' }}</p>
                                    @php
                                        $total_coupon = 0;
                                    @endphp
                                    @if ($allDonHang->MaGiamGia != 0 && $allDonHang->PhieuGiamGia->DonViTinh == 1 )
                                        @php
                                            echo 'Mã giảm giá theo tiền: '.number_format($allDonHang->PhieuGiamGia->TriGia, 0,',','.').'đ'.'<br>';
                                            $total_after = $total - $allDonHang->PhieuGiamGia->TriGia + $allDonHang->GiaoHang->TienGiaoHang;
                                        @endphp
                                    @elseif ($allDonHang->MaGiamGia != 0 && $allDonHang->PhieuGiamGia->DonViTinh == 2)
                                        @php
                                            $total_after_coupon = $total * $allDonHang->PhieuGiamGia->TriGia / 100;
                                            echo 'Mã giảm giá '.$allDonHang->PhieuGiamGia->TriGia.'%: '   .number_format($total_after_coupon, 0,',','.').'đ'.'<br>';
                                            $total_after = $total - $total_after_coupon + $allDonHang->GiaoHang->TienGiaoHang;
                                        @endphp
                                    @elseif ($allDonHang->MaGiamGia == 0)
                                        @php
                                            echo '<p>' . 'Giảm giá: 0' . ' </p>';
                                            $total_after = $total + $allDonHang->GiaoHang->TienGiaoHang;
                                        @endphp
                                    @endif
                                    <p>Thanh toán: {{ number_format($total_after, 0,',','.').'đ' }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

{{--                hoan/tra hang / huy don--}}
                <div class="row" style="margin-bottom: 6%">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3">

                        @if($allDonHang->TrangThai == 1)
                            <form action="{{Route('HuyDon', [$allDonHang->MaDonHang])}}" method="post">
                                @csrf
                                 <button class="btn-info btn" type="submit">Hủy đơn</button>

                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
