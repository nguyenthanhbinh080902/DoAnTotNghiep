@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật danh mục bài viết bài viết
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
                <form role="form" action="{{ Route('/SuaDanhMucBV', [$danhMucBaiViet->MaDanhMucBV]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                        <input type="text" value="{{ $danhMucBaiViet->TenDanhMucBV }}" class="form-control" name="TenDanhMucBV" placeholder="Tên danh mục bài viết" onkeyup="ChangeToSlug();" id="slug" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Slug danh mục bài viết</label>
                        <input type="text" value="{{ $danhMucBaiViet->SlugDanhMucBV }}" class="form-control" name="SlugDanhMucBV" placeholder="Slug" id="convert_slug">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả</label>
                        <textarea id="editor2" style="resize: none" value="" rows="5" class="form-control" name="MoTa" placeholder="Mô tả danh mục bài viết">{{ $danhMucBaiViet->MoTa }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Trạng thái danh mục bài viết</label>
                        <select name="TrangThai" class="form-control input-lg m-bot15">
                        @if ($danhMucBaiViet->TrangThai == '1')
                            <option value="1" selected>Hiển thị</option>
                            <option value="0" >Không hiển thị</option>
                        @else
                            <option value="1" >Hiển thị</option>
                            <option value="0" selected>Không hiển thị</option>
                        @endif
                        </select>
                    </div>
                    <button type="submit" name="SuaDanhMucBV" class="btn btn-info">Cập nhật danh mục bài viết</button>
                </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection