@extends('admin_layout')
@section('admin_content')

@php 
    if($pth->TrangThai == 0){
        $tt = "Chưa xác nhận";
    }else{
        $tt = "Đã xác nhận";
    }
@endphp 
<style>
    
    
</style>
<div class="table-agile-info">
    <div class="panel panel-default">
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
                    <p><strong>Mã phiếu nhập:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pth->MaPhieuNhap}}</p>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <p><strong>Nhà cung cấp:</strong></p>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <p> {{$pth->TenNhaCungCap}}</p>
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
                    <p>{{$tt}}</p>
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
                    <p> {{$pth->ThoiGianSua}}</p>
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
                            <td>{{ $matHang->GiaSanPham }}</td>
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
                    <p><strong></strong>{{ $pth->TongTien }}</p>
                </div>
            </div>
        </div>
        
    </div>
    <!-- <a href="{{ route('xemPTH') }}"><button class="btn btn-info">Trở lại</button></a> -->
    <a href="{{ route('suaPTH', ['id' => $pth->MaPhieuTraHang]) }}"><button class="btn btn-info">Sửa</button></a>
</div>
@endsection
