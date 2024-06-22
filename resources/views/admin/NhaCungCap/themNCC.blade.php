@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm nhà cung cấp
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" id="from" action="/xuLyThemNCC" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="tennhacungcap">Tên nhà cung cấp:</label>
                            <input class="form-control" type="hidden" id="nccMoi" name="nccMoi" value="{{ $test }}" readonly>
                            <input class="form-control" type="text" id="tennhacungcap" name="tennhacungcap" value="{{ old('tennhacungcap') }}">
                        </div>
                        @error('tennhacungcap')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="diachi">Địa chỉ:</label>
                            <input class="form-control" type="text" id="diachi" name="diachi" value="{{ old('diachi') }}">
                        </div>
                        @error('diachi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="nguoiDaiDien">Người đại diện:</label>
                            <input class="form-control" type="text" id="nguoiDaiDien" name="nguoiDaiDien" value="{{ old('nguoiDaiDien') }}">
                        </div>
                        @error('nguoiDaiDien')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="sdt">Số điện thoại:</label>
                            <input class="form-control" type="number" id="sdt" name="sdt" value="{{ old('sdt') }}">
                        </div>
                        @error('sdt')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
