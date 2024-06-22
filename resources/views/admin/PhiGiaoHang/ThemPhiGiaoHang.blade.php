@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel" style="height: 600px">
            <header class="panel-heading">
                Thêm phí giao hàng
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
                    <form role="form" action="{{ Route('/ThemPhiGiaoHang') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn thành phố</label>
                            <select name="MaThanhPho" id="MaThanhPho" class="form-control input-lg m-bot15 ChonDiaDiem MaThanhPho">
                                <option value="" >--Chọn thành phố--</option>
                                @foreach ($allThanhPho as $key => $thanhPho)
                                    <option value="{{ $thanhPho->MaThanhPho }}" >{{ $thanhPho->TenThanhPho }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn quận huyện</label>
                            <select name="MaQuanHuyen" id="MaQuanHuyen" class="form-control input-lg m-bot15 ChonDiaDiem MaQuanHuyen">
                                <option value="" >--Chọn quận huyện--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn xã phường</label>
                            <select name="MaXaPhuong" id="MaXaPhuong" class="form-control input-lg m-bot15 MaXaPhuong">
                                <option value="" >--Chọn xã phường--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Điền phí giao hàng</label>
                            <input type="text" class="form-control" name="PhiGiaoHang" placeholder="Phí giao hàng">
                        </div>
                        <button type="submit" name="ThemPhiGiaoHang" class="btn btn-info">Thêm phí giao hàng</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection