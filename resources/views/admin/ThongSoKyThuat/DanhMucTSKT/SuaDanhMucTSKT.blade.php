@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật Danh mục thông số kỹ thuật
            </header>
            <div class="panel-body">
                <div class="position-center">
                    @foreach ($danhMucTSKT as $key => $value)
                    <form role="form" action="{{ Route('/SuaDanhMucTSKT', [$value->MaDMTSKT]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục thông số kỹ thuật</label>
                            <input type="text" value="{{ $value->TenDMTSKT }}" class="form-control @error('TenDMTSKT') is-invalid @enderror" name="TenDMTSKT" placeholder="Tên danh mục thông số kỹ thuật" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenDMTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" value="{{ $value->SlugDMTSKT }}" class="form-control @error('SlugDMTSKT') is-invalid @enderror" name="SlugDMTSKT" placeholder="Slug" id="convert_slug">
                        </div>
                        @error('SlugDMTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục cha</label>
                                <select name="DanhMucCha" id="DanhMucCha" class="form-control input-lg m-bot15 choose DanhMucCha">
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

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor2" style="resize: none" value="" rows="5" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả danh mục thông số kỹ thuật">{{ $value->MoTa }}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái danh mục thông số kỹ thuật</label>
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

                        <button type="submit" name="SuaSanPham" class="btn btn-info">Cập nhật danh mục thông số kỹ thuật</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
