@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật bài viết
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
                    <form role="form" action="{{ Route('/SuaBaiViet', $baiViet->MaBaiViet) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên bài viết</label>
                            <input type="text" value="{{ $baiViet->TenBaiViet }}" class="form-control" name="TenBaiViet" placeholder="Tên bài viết" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" value="{{ $baiViet->SlugBaiViet }}" class="form-control" name="SlugBaiViet" placeholder="Slug" id="convert_slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục bài viết</label>
                            <select name="MaDanhMucBV" class="form-control input-lg m-bot15">
                                @foreach ($allDanhMucBV as $key => $danhMucBV)
                                @if ($baiViet->MaDanhMucBV == $danhMucBV->MaDanhMucBV)
                                    <option selected value="{{ $baiViet->MaDanhMucBV }}" >{{ $baiViet->DanhMucBV->TenDanhMucBV }}</option>
                                @else
                                    <option value="{{ $danhMucBV->MaDanhMucBV }}" >{{ $danhMucBV->TenDanhMucBV }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea id="MoTa" style="resize: none" value="" rows="10" class="form-control" name="MoTa" placeholder="Mô tả bài viết">{{ $baiViet->MoTa }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control-file" name="HinhAnh">
                            <img src="{{ asset('upload/BaiViet/'.$baiViet->HinhAnh) }}" height="100px" width="150px">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng thái bài viết</label>
                            <select name="TrangThai" class="form-control input-lg m-bot15">
                            @if ($baiViet->TrangThai == '1')
                                <option value="1" selected>Hiển thị</option>
                                <option value="0" >Không hiển thị</option>
                            @else
                                <option value="1" >Hiển thị</option>
                                <option value="0" selected>Không hiển thị</option>
                            @endif
                            </select>
                        </div>
                        <button type="submit" name="SuaBaiViet" class="btn btn-info">Cập nhật bài viết</button>
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