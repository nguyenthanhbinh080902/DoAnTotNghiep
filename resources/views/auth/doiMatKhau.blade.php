<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>

<body>
<div class="container-custom">
    <h2>Đổi mật khẩu</h2>
    <form action="/doi-mat-khau" method="POST">
        @csrf

        <input type="password" class="form-control @error('MatKhauCu') is-invalid @enderror" name="MatKhauCu"
               placeholder="Mật khẩu cũ" value="{{ old('MatKhauCu') }}">
        @error('MatKhauCu')
        <div class="alert alert-danger ">
            {{ $message }}
        </div>
        @enderror
        <input type="password" name="MatKhauMoi" class="form-control @error('MatKhauMoi') is-invalid @enderror"
               placeholder="Mật khẩu mới" value="{{ old('MatKhauMoi') }}">
        @error('MatKhauMoi')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror
        <input type="password" name="MatKhauMoi2" class="form-control @error('MatKhauMoi2') is-invalid @enderror"
               placeholder="Nhập lại mật khẩu mới" value="{{ old('MatKhauMoi2') }}">
        @error('MatKhauMoi2')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror
        <input type="submit" value="Đổi mật khẩu">
    </form>

    <a href="{{ route('/') }}" class="link-dn">Về trang chủ?</a>


</div>
</body>

</html>
