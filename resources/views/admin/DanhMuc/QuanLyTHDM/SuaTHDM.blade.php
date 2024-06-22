@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel" style="height: 600px">
            <header class="panel-heading">
                Cập nhật Thương hiệu thuộc danh mục
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
                    @foreach ($thuongHieuDanhMuc as $key => $value)
                    <form role="form" action="{{ Route('/sua-thdm', [$value->MaTHDM]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Thương hiệu của danh mục</label>
                            <select name="MaThuongHieu" class="form-control input-lg m-bot15">
                                @foreach ($allThuongHieu as $key => $valueThuongHieu)
                                @if ($value->MaThuongHieu  == $valueThuongHieu->MaThuongHieu)
                                    <option selected value="{{ $valueThuongHieu->MaThuongHieu }}" >{{ $valueThuongHieu->TenThuongHieu }}</option>
                                @else
                                    <option value="{{ $valueThuongHieu->MaThuongHieu }}" >{{ $valueThuongHieu->TenThuongHieu }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục cha</label>
                                <select name="DanhMucCha" id="DanhMucCha" class="form-control input-lg m-bot15 chonDanhMucTSKT DanhMucCha">
                                    @foreach ($allDanhMuc as $key => $valueDanhMuc)
                                        @if ($value->MaDanhMuc == $valueDanhMuc->MaDanhMuc)
                                            <option selected value="{{ $valueDanhMuc->MaDanhMuc }}" >---{{ $valueDanhMuc->TenDanhMuc }}---</option>
                                        @elseif ($valueDanhMuc->DanhMucCha == 0)
                                            <option value="{{ $valueDanhMuc->MaDanhMuc }}" >{{ $valueDanhMuc->TenDanhMuc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 DanhMucCon">
                                    <option value="">---Chọn danh mục con---</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="SuaSanPham" class="btn btn-info">Cập nhật thương hiệu danh mục</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection