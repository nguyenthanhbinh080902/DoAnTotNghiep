<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-custom">
        <h2>Đăng ký</h2>
        <form action="/xu-ly-dang-ky" method="POST">
            @csrf
            <input type="text" class="form-control @error('tentaikhoan') is-invalid @enderror" name="tentaikhoan" placeholder="Tên tài khoản" value="{{ old('tentaikhoan') }}">
            @error('tentaikhoan')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <input type="password" class="form-control @error('matkhau') is-invalid @enderror" name="matkhau" placeholder="Mật khẩu" value="{{ old('matkhau') }}">
            @error('matkhau')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <input type="submit" value="Đăng ký">

        </form>
        <a href="{{ route('/') }}" class="link-dn">Về trang chủ?</a>
        <a href="{{ route('dangNhap') }}" class="link-dn">Đăng nhập?</a>

    </div>
</body>
</html>
