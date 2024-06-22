@extends('admin_layout')
@section('admin_content')
@php 
    if($pn->TrangThai == 0){
        $tt = "Chưa xác nhận";
    }else{
        $tt = "Đã xác nhận";
    }
    if($pn->PhuongThucThanhToan == 0){
        $thanhtoan = "Chuyển khoản";
    }elseif($pn->PhuongThucThanhToan == 1){
        $thanhtoan = "Tiền mặt";
    }else{
        $thanhtoan = "Khác";
    }
    if(!empty($pth)){
        $a = 0;
    }else{
        $a = 1;
    }
@endphp 
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết phiếu nhập
        </div>
        <div class="container">
            <div class="row r1">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Mã phiếu nhập:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{$pn->MaPhieuNhap}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Nhà cung cấp:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pn->TenNhaCungCap}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Người lập:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pn->TenTaiKhoan}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Trạng thái:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{$tt}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Thanh toán qua:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{ $thanhtoan }}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Thời gian tạo:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pn->ThoiGianTao}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Thời gian sửa:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pn->ThoiGianSua}}</p>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ctpn as $key => $matHang)
                        <tr>
                            <td>{{ $matHang->TenSanPham }}</td>
                            <td>{{ $matHang->SoLuong }}</td>
                            <td>{{ number_format($matHang->GiaSanPham, 0, '', '.') }}</td>
                            @php
                                $thanhTien = $matHang->SoLuong * $matHang->GiaSanPham;
                            @endphp
                            <td>{{ number_format($thanhTien, 0, '', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="container">
            <div class="row r1">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Tổng tiền:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{ number_format($pn->TongTien, 0, '', '.') }}</p>
                </div>
                
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Tiền trả:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{ $pn->TienTra == null ? 0 : number_format($pn->TienTra, 0, '', '.')  }}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Tiền nợ:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{ number_format($pn->TienNo, 0, '', '.')}}</p>
                </div>
            </div>
        </div>
        
    </div>
    <!-- <a href="{{ route('xemPN') }}"><button class="btn btn-info">Quay lại danh sách</button></a> -->
    
    <a href="{{ route('suaPN', ['id' => $pn->MaPhieuNhap]) }}"><button class="btn btn-info">Sửa phiếu nhập</button></a>
    <a href="{{ route('xuatFilePN', ['id' => $pn->MaPhieuNhap]) }}"><button class="btn btn-info">Xuất file</button></a>
    
    @if($pn->TrangThai == 1 && $a == 1)
        <a href="{{ route('lapTH', ['id' => $pn->MaPhieuNhap, 'maNCC' => $pn->MaNhaCungCap]) }}"><button class="btn btn-info">Lập phiếu trả hàng</button></a>
    @endif
    @if (!empty($pth))
    @php 
        if($pth->TrangThai == 0){
            $ttPTH = "Chưa xác nhận";
        }else{
            $ttPTH = "Đã xác nhận";
        }
    @endphp
    <div class="panel panel-default" style="margin-top: 5px">
        <div class="panel-heading">
            Thông tin phiếu trả hàng
        </div>
        <div class="container">
            <div class="row r1">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Mã phiếu trả hàng:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{$pth->MaPhieuTraHang}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Người lập:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pth->TenTaiKhoan}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Trạng thái:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{$ttPTH}}</p>
                </div>
                
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Thời gian tạo:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pth->ThoiGianTao}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Thời gian sửa:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p>{{$pth->ThoiGianSua}}</p>
                </div>
            </div>
        </div> 
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Lý do trả hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ctth as $key => $matHang)
                        <tr>
                            <td>{{ $matHang->TenSanPham }}</td>
                            <td>{{ $matHang->SoLuong }}</td>
                            <td>{{ number_format($matHang->GiaSanPham, 0, '', '.') }}</td>
                            <td>{{ $matHang->LyDoTraHang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="container">
            <div class="row r1">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong></strong><strong>Tổng tiền:</strong></p>
                </div>
                <div class="col-sm-6">
                    <p><strong></strong>{{ number_format($pth->TongTien, 0, '', '.') }}</p>
                </div>
            </div>
        </div>
        <div style="margin:10px 12px; padding: 5px">
            <a href="{{ route('suaPTH', ['id' => $pth->MaPhieuTraHang]) }}"><button class="btn btn-info">Sửa phiếu trả hàng</button></a>
            @if ($pth->TrangThai == 0)
                <a onclick="return confirm('Bạn có muốn xóa phiếu trả hàng có mã {{ $pth->MaPhieuTraHang }} không?')" href="{{ route('xoaPTH', [$pth->MaPhieuTraHang]) }}"><button class="btn btn-info">Xóa phiếu trả hàng</button></a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
