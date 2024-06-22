@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel" style="height: 600px">
            <header class="panel-heading">
                Thêm thương hiệu vào danh mục
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
                    <form role="form" action="{{ Route('/them-thdm') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                            <select name="MaThuongHieu" class="form-control input-lg m-bot15">
                                <option value="" >--Chọn thương hiệu--</option>
                                @foreach ($allThuongHieu as $key => $thuongHieu)
                                    <option value="{{ $thuongHieu->MaThuongHieu }}" >{{ $thuongHieu->TenThuongHieu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục cha</label>
                                <select name="DanhMucCha" id="DanhMucCha" class="form-control input-lg m-bot15 chonDanhMucTSKT DanhMucCha">
                                    <option value="">--Chọn danh mục cha--</option>
                                    @foreach ($allDanhMuc as $key => $danhMuc)
                                        @if ($danhMuc->DanhMucCha == 0)
                                            <option value="{{ $danhMuc->MaDanhMuc }}" >{{ $danhMuc->TenDanhMuc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 DanhMucCon">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="ThemSanPham" class="btn btn-info">Thêm thương hiệu vào danh mục</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection