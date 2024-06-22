@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Tạo tài khoản
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" id="from" action="{{ Route('xuLyTaoTK')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="tentaikhoan">Tên tài khoản:</label>
                            <input class="form-control" type="text" id="tentaikhoan" name="tentaikhoan" value="{{ old('tentaikhoan') }}">
                        </div>
                        @error('tentaikhoan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="matkhau">Mật khẩu:</label>
                            <input class="form-control" type="text" id="matkhau" name="matkhau" value="{{ old('matkhau') }}">
                        </div>
                        @error('matkhau')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="sdt">Số điện thoại:</label>
                            <input class="form-control" type="text" id="sdt" name="sdt" value="{{ old('sdt') }}">
                        </div>
                        @error('sdt')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="quyen">Vai trò:</label>
                            <select id="quyen" class="form-control input-lg m-bot15" name="quyen">
                                @foreach ($quyen as $i)
                                    <option value="{{ $i->TenPhanQuyen }}">{{ $i->TenPhanQuyen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </form>
                    <a href="{{ route('lietKeTK') }}"><button class="btn btn-info" style="margin-top:5px;">Trở lại</button></a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection