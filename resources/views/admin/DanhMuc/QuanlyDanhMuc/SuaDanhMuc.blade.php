@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật danh mục sản phẩm
            </header>
            <div class="panel-body">
                <div class="position-center">
                @foreach ($suaDanhMuc as $key => $value)
                    <form role="form" action="{{ Route('/SuaDanhMuc', [$value->MaDanhMuc]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{ $value->TenDanhMuc }}" class="form-control @error('TenDanhMuc') is-invalid @enderror" name="TenDanhMuc" placeholder="Tên danh mục" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenDanhMuc')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" value="{{ $value->SlugDanhMuc }}" class="form-control @error('SlugDanhMuc') is-invalid @enderror" name="SlugDanhMuc" placeholder="Slug" id="convert_slug">
                        </div>
                        @error('SlugDanhMuc')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor2" style="resize: none" value="" rows="5" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả danh mục">{{ $value->MoTa }}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Thuộc danh mục</label>
                            <select name="DanhMucCha" class="form-control input-lg m-bot15">
                                <option value="0">---Chuyển thành danh mục cha---</option>
                                @foreach ($danhMuc as $key => $value1)
                                    @if ($value1->DanhMucCha == 0)
                                        <option {{ $value1->MaDanhMuc == $value->MaDanhMuc ? 'selected' : '' }} value="{{ $value1->MaDanhMuc }}" >{{ $value1->TenDanhMuc }}</option>
                                    @endif

                                    @foreach ($danhMuc as $key => $value2)
                                        @if ($value2->DanhMucCha == $value1->MaDanhMuc)
                                            <option {{ $value2->MaDanhMuc == $value->MaDanhMuc ? 'selected' : '' }} value="{{ $value2->MaDanhMuc }}" >-----{{ $value2->TenDanhMuc }}-----</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái danh mục</label>
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

                        <button type="submit" name="SuaDanhMuc" class="btn btn-info">Cập nhật danh mục</button>
                    </form>
                @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
