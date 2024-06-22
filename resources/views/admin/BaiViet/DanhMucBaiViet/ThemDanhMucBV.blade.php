@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục bài viết
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ Route('/ThemDanhMucBV') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                            <input type="text" class="form-control @error('TenDanhMucBV') is-invalid @enderror" value="{{old('TenDanhMucBV')}}" name="TenDanhMucBV" placeholder="Tên danh mục bài viết" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenDanhMucBV')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug danh mục bài viết</label>
                            <input type="text" class="form-control @error('SlugDanhMucBV') is-invalid @enderror" value="{{old('SlugDanhMucBV')}}" name="SlugDanhMucBV" placeholder="Slug danh mục bài viết" id="convert_slug">
                        </div>
                        @error('SlugDanhMucBV')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="editor1" style="resize: none" rows="10" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả">{{old('MoTa')}}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái danh mục bài viết</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15">
                                <option value="1" >Hiển thị</option>
                                <option value="0" >Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="ThemDanhMucBV" class="btn btn-info">Thêm danh mục bài viết</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
