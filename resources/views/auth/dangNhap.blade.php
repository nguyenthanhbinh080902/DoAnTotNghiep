<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-custom">
        <h2>Đăng nhập</h2>
        <form action="/xuLyDN" method="POST">
            @csrf
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <input type="password" class="form-control @error('matkhau') is-invalid @enderror" name="matkhau" placeholder="Mật khẩu" value="{{ old('matkhau') }}">
            @error('matkhau')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <input type="submit" value="Đăng nhập">

        </form>
        <a href="{{ route('dangKy') }}" class="link-dn">Chưa có tài khoản? Đăng ký!</a>
        <a href="{{ route('quenMatKhau') }}" class="link-dn">Quên mật khẩu?</a>
        <a href="{{ route('/') }}" class="link-dn">Về trang chủ?</a>


    </div>
</body>
</html>
