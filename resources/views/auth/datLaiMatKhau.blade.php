<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-custom">
        <h2>Đặt lại mật khẩu</h2>
        <form action="/dat-lai-mat-khau" method="POST">
            @csrf
            <div class="form-group">
                <input type="password" class="form-control @error('MatKhauMoi') is-invalid @enderror" name="MatKhauMoi" placeholder="Mật khẩu mới" value="{{ old('MatKhauMoi') }}">
            </div>
            @error('MatKhauMoi')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            <input type="password" class="form-control @error('MatKhauMoi2') is-invalid @enderror" name="MatKhauMoi2" placeholder="Nhập lại mật khẩu mới" value="{{ old('MatKhauMoi2') }}">
            @error('MatKhauMoi2')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            <input type="submit" value="Đổi mật khẩu">
        </form>


    </div>
</body>
</html>
