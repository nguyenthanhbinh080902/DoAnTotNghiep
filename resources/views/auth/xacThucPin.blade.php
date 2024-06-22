<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Pin</title>
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-custom">
        <h2>Xác thực Pin</h2>
        <form action="/xac-thuc-pin" method="POST">
            @csrf
            <input type="text" class="form-control @error('Pin') is-invalid @enderror" name="Pin" placeholder="Pin">
            @error('Pin')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            <input type="submit" value="Gửi">

        </form>
        <a href="{{ route('/') }}" class="link-dn">Về trang chủ?</a>


    </div>
</body>
</html>
