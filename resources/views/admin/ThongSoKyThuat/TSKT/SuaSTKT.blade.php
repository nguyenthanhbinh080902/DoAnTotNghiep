@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật thông số kỹ thuật
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
                    @foreach ($thongSoKyThuat as $key => $value)
                    <form role="form" action="{{ Route('/SuaTSKT', [$value->MaTSKT]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thông số kỹ thuật</label>
                            <input type="text" value="{{ $value->TenTSKT }}" class="form-control" name="TenTSKT" placeholder="Tên thông số kỹ thuật" onkeyup="ChangeToSlug();" id="slug">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Slug</label>
                          <input type="text" value="{{ $value->SlugTSKT }}" class="form-control" name="SlugTSKT" placeholder="Slug" id="convert_slug">
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
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
                            <div class="col-lg-4">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 chonDanhMucTSKT DanhMucCon">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="exampleInputPassword1">Chọn danh mục TSKT</label>
                                <select name="DanhMucTSKT" id="DanhMucTSKT" class="form-control input-lg m-bot15 DanhMucTSKT">
                                    @foreach ($allDanhMucTSKT as $key => $danhMucTSKT)
                                        @if ($danhMucTSKT->MaDMTSKT == $value->MaDMTSKT)
                                            <option selected value="{{ $danhMucTSKT->MaDMTSKT }}" >-- {{ $danhMucTSKT->TenDMTSKT }} --</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor2" style="resize: none" value="" rows="5" class="form-control" name="MoTa" placeholder="Mô tả thông số kỹ thuật">{{ $value->MoTa }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái thông số kỹ thuật</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15">
                            @if ($value->TrangThai == '1')
                                <option value="1" selected>Hiển thị</option>
                                <option value="0" >Không hiển thị</option>
                            @else
                                <option value="1" >Hiển thị</option>
                                <option value="0" selected>Không hiển thị</option>
                            @endif
                            </select>
                        </div>
                        <button type="submit" name="SuaTSKT" class="btn btn-info">Cập nhật thông số kỹ thuật</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection