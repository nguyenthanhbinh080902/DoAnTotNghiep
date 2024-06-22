@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel" style="height: 600px">
            <header class="panel-heading">
                Cập nhật thông tin giao hàng
            </header>
            <div class="panel-body">
                <div class="position-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form role="form" action="{{ Route('/SuaThongTinGiaoHang', [$giaoHang->MaGiaoHang, $order_code]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên người nhận hàng</label>
                            <input type="text" value="{{ $giaoHang->TenNguoiNhan }}" class="form-control" name="TenNguoiNhan" placeholder="Tên người nhận">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Số điện thoại</label>
                          <input type="text" value="{{ $giaoHang->SoDienThoai }}" class="form-control" name="SoDienThoai">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Địa chỉ giao hàng</label>
                            <textarea style="resize: none" value="" rows="5" class="form-control" name="DiaChi" placeholder="Địa chỉ giao hàng">{{ $giaoHang->DiaChi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ghi chú</label>
                            <textarea style="resize: none" value="" rows="5" class="form-control" name="GhiChu" placeholder="Ghi chú">{{ $giaoHang->GhiChu }}</textarea>
                        </div>
                        <button type="submit" name="SuaThuongHieu" class="btn btn-info">Cập nhật thông tin giao hàng</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection