@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thông số kỹ thuật
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ Route('/ThemTSKT') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên Thông số kỹ thuật</label>
                            <input type="text" class="form-control @error('TenTSKT') is-invalid @enderror" value="{{old('TenTSKT')}}" name="TenTSKT" placeholder="Tên Thông số kỹ thuật" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" class="form-control @error('SlugTSKT') is-invalid @enderror" value="{{old('SlugTSKT')}}" name="SlugTSKT" placeholder="Slug" id="convert_slug">
                        </div>
                        @error('SlugTSKT')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group row">
                            <div class="col-lg-4">
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

                            <div class="col-lg-4">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 chonDanhMucTSKT DanhMucCon">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label for="exampleInputPassword1">Chọn danh mục TSKT</label>
                                <select name="DanhMucTSKT" id="DanhMucTSKT" class="form-control input-lg m-bot15 DanhMucTSKT">
                                    <option value=""></option>
                                </select>

                                @error('DanhMucTSKT')
                                    <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor1" style="resize: none" rows="5" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả">{{old('MoTa')}}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái Thông số kỹ thuật</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15">
                                <option value="" >--Chọn trạng thái--</option>
                                <option value="1" >Hiển thị</option>
                                <option value="0" >Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="ThemTSKT" class="btn btn-info">Thêm Thông số kỹ thuật</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
