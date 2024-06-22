@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Điền thông tin lịch sử bảo hành
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
                    <form role="form" action="{{ Route('/ThemLichSuBaoHanh', $MaCTPBH) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng sản phẩm bảo hành</label>
                            <input type="number" class="form-control" name="SoLuong" max="{{ $chiTietPBH->SoLuong }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ghi chú tình trạng của sản phẩm</label>
                            <textarea id="editor1" style="resize: none" rows="5" class="form-control" name="TinhTrang" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn thời gian trả hàng</label>
                            <input type="date" class="form-control" name="ThoiGianTra" max="{{ $chiTietPBH->ThoiGianKetThuc }}" placeholder="Thời gian trả">
                        </div>
                        <button type="submit" name="ThemLichSuBaoHanh" class="btn btn-info">Thêm lịch sử bảo hành</button>
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
