@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ Route('/ThemSanPham') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" class="form-control @error('TenSanPham') is-invalid @enderror" value="{{old('TenSanPham')}}" name="TenSanPham" placeholder="Tên sản phẩm" onkeyup="ChangeToSlug();" id="slug" >
                        </div>
                        @error('TenSanPham')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" class="form-control @error('SlugSanPham') is-invalid @enderror" value="{{old('SlugSanPham')}}" name="SlugSanPham" placeholder="Slug" id="convert_slug">
                        </div>
                        @error('SlugSanPham')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                            <select name="MaThuongHieu" class="form-control input-lg m-bot15">
                                <option value="" >--Chọn thương hiệu--</option>
                                @foreach ($allThuongHieu as $key => $thuongHieu)
                                    <option value="{{ $thuongHieu->MaThuongHieu }}" {{ old('MaThuongHieu') == $thuongHieu->MaThuongHieu ? 'selected' : '' }}>
                                        {{ $thuongHieu->TenThuongHieu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục cha</label>
                                <select name="DanhMucCha" id="DanhMucCha" class="form-control input-lg m-bot15 ThemTSKTChoSanPham DanhMucCha">
                                    <option value="">--Chọn danh mục cha--</option>
                                    @foreach ($allDanhMuc as $key => $danhMuc)
                                        @if ($danhMuc->DanhMucCha == 0)
                                            <option value="{{ $danhMuc->MaDanhMuc }}" {{ old('DanhMucCha') == $danhMuc->MaDanhMuc ? 'selected' : '' }}>{{ $danhMuc->TenDanhMuc}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="exampleInputPassword1">Chọn danh mục con</label>
                                <select name="DanhMucCon" id="DanhMucCon" class="form-control input-lg m-bot15 ThemTSKTChoSanPham DanhMucCon">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="exampleInputPassword1">Chiều cao (Đơn vị cm)</label>
                                <input type="text" class="form-control @error('ChieuCao') is-invalid @enderror" value="{{old('ChieuCao')}}" name="ChieuCao" placeholder="Chiều cao">
                            </div>
                            @error('ChieuCao')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror

                            <div class="col-lg-3">
                                <label for="exampleInputPassword1">Chiều ngang (Đơn vị cm)</label>
                                <input type="text" class="form-control @error('ChieuNgang') is-invalid @enderror" value="{{old('ChieuNgang')}}" name="ChieuNgang" placeholder="Chiều ngang">
                            </div>
                            @error('ChieuNgang')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror

                            <div class="col-lg-3">
                                <label for="exampleInputPassword1">Chiều dày (Đơn vị cm)</label>
                                <input type="text" class="form-control @error('ChieuDay') is-invalid @enderror" value="{{old('ChieuDay')}}" name="ChieuDay" placeholder="Chiều dày">
                            </div>
                            @error('ChieuDay')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror

                            <div class="col-lg-3">
                                <label for="exampleInputPassword1">Cân nặng (Đơn vị kg)</label>
                                <input type="text" class="form-control @error('CanNang') is-invalid @enderror" value="{{old('CanNang')}}" name="CanNang" placeholder="Cân nặng">
                            </div>
                            @error('CanNang')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror

                        </div>
                        <div class="form-group DanhMucTSKT" id="DanhMucTSKT" name="DanhMucTSKT">
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
                            <label for="TrangThai">Trạng thái sản phẩm</label>
                            <select id="TrangThai" name="TrangThai" class="form-control input-lg m-bot15">
                                <option value="" >--Chọn trạng thái--</option>
                                <option value="1" >Đang bán</option>
                                <option value="0" >Ngừng bán</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="SoTien">Giá sản phẩm</label>
                            <input type="text" id="SoTien" class="form-control @error('SoTien') is-invalid @enderror" value="{{old('SoTien')}}" name="SoTien" placeholder="Giá sản phẩm">
                        </div>
                        @error('SoTien')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Thời gian bảo hành (theo tháng)</label>
                            <input type="text" class="form-control @error('ThoiGianBaoHanh') is-invalid @enderror" value="{{old('ThoiGianBaoHanh')}}" name="ThoiGianBaoHanh" placeholder="Thời hạn bảo hành (Theo tháng)">
                        </div>
                        @error('ThoiGianBaoHanh')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <button type="submit" name="ThemSanPham" class="btn btn-info">Thêm sản phẩm</button>
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
