@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục thông số kỹ thuật
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ Route('/ThemDanhMucTSKT') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục thông số kỹ thuật</label>
                            <input type="text" class="form-control @error('TenDMTSKT') is-invalid @enderror" name="TenDMTSKT" value="{{old('TenDMTSKT')}}" placeholder="Tên danh mục thông số kỹ thuật" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenDMTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" class="form-control @error('SlugDMTSKT') is-invalid @enderror" value="{{old('SlugDMTSKT')}}" name="SlugDMTSKT" placeholder="Slug" id="convert_slug">
                        </div>
                        @error('SlugDMTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục cha</label>
                                <select name="DanhMucCha" id="DanhMucCha" class="form-control input-lg m-bot15 chonDanhMucTSKT DanhMucCha @error('DanhMucCha') is-invalid @enderror">
                                    <option value="">--- Chọn danh mục cha ---</option>
                                    @foreach ($allDanhMuc as $key => $danhMuc)
                                        @if ($danhMuc->DanhMucCha == 0)
                                            <option value="{{ $danhMuc->MaDanhMuc }}" {{ old('DanhMucCha') == $danhMuc->MaDanhMuc ? 'selected' : '' }}>{{ $danhMuc->TenDanhMuc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('DanhMucCha')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>


                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 DanhMucCon">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor1" style="resize: none" rows="3" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả">{{old('MoTa')}}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái danh mục thông số kỹ thuật</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15 @error('TrangThai') is-invalid @enderror">
                                <option value="">--Chọn trạng thái--</option>
                                <option value="1" {{ old('TrangThai') == '1' ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ old('TrangThai') == '0' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                        @error('TrangThai')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <button type="submit" name="ThemDanhMucTSKT" class="btn btn-info">Thêm danh mục thông số kỹ thuật</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
