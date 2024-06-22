<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-custom">
        <h2>Quên mật khẩu</h2>
        <form action="/quen-mat-khau" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="Email" placeholder="Email" class="form-control @error('Email') is-invalid @enderror">
            </div>
            @error('Email')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            <input type="submit" value="Gửi mã Pin">

        </form>
        <a href="{{ route('dangKy') }}" class="link-dn">Chưa có tài khoản? Đăng ký!</a>
        <a href="{{ route('/') }}" class="link-dn">Về trang chủ?</a>


    </div>
</body>
</html>
