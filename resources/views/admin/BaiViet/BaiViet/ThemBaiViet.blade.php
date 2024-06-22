@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm bài viết
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ Route('/ThemBaiViet') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên bài viết</label>
                            <input type="text" class="form-control @error('TenBaiViet') is-invalid @enderror" value="{{old('TenBaiViet')}}" name="TenBaiViet" placeholder="Tên bài viết" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenBaiViet')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug bài viết</label>
                            <input type="text" class="form-control @error('SlugBaiViet') is-invalid @enderror" value="{{old('SlugBaiViet')}}" name="SlugBaiViet" placeholder="Slug bài viết" id="convert_slug">
                        </div>
                        @error('SlugBaiViet')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục bài viết</label>
                            <select name="MaDanhMucBV" class="form-control input-lg m-bot15 @error('MaDanhMucBV') is-invalid @enderror">
                                <option value="" >--Chọn Danh mục--</option>
                                @foreach ($allDanhMucBV as $key => $danhMucBV)
                                    <option value="{{ $danhMucBV->MaDanhMucBV }}"  {{old('MaDanhMucBV') == $danhMucBV->MaDanhMucBV ? 'selected': ''}}>{{ $danhMucBV->TenDanhMucBV }}</option>
                                @endforeach
                            </select>
                            @error('MaDanhMucBV')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="MoTa" style="resize: none" rows="10" class="form-control @error('MoTa') is-invalid @enderror" name="MoTa" placeholder="Mô tả">{{old('MoTa')}}</textarea>
                        </div>
                        @error('MoTa')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn hình ảnh</label>
                            <input type="file" class="form-control @error('HinhAnh') is-invalid @enderror" name="HinhAnh" placeholder="Hình ảnh">
                        </div>
                        @error('HinhAnh')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái bài viết</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15">
                                <option value="" >--Chọn trạng thái--</option>
                                <option value="1" >Hiển thị</option>
                                <option value="0" >Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="ThemBaiViet" class="btn btn-info">Thêm bài viết</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('js-custom')
    <script>
        ClassicEditor
        .create(document.querySelector('#MoTa'))
        .catch(error => {
            console.error(error);
        })
    </script>
@endsection
