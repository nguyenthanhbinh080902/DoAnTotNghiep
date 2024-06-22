<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sửa tài khoản</title>
    <style>
        /* Thiết lập phần tử label */
        label {
            display: block; /* Hiển thị mỗi nhãn trên một dòng mới */
            margin-bottom: 5px; /* Khoảng cách giữa các nhãn */
        }

        /* Thiết lập phần tử input */
        input {
            width: 100%; /* Độ rộng của ô textbox */
            padding: 5px; /* Khoảng cách bên trong ô textbox */
            margin-bottom: 10px; /* Khoảng cách giữa các ô textbox */
            border: 1px solid #ccc; /* Đường viền của ô textbox */
            border-radius: 4px; /* Bo tròn các góc của ô textbox */
            box-sizing: border-box; /* Kích thước ô textbox bao gồm cả padding và border */
        }

        /* Thiết lập phần tử button */
        .edit-btn {
            padding: 8px 16px; /* Kích thước nút */
            background-color: #4CAF50; /* Màu nền của nút */
            color: white; /* Màu chữ của nút */
            border: none; /* Không có đường viền */
            border-radius: 4px; /* Bo tròn các góc */
            cursor: pointer; /* Con trỏ thành dạng bàn tay khi di chuột vào nút */
        }

        /* Thiết lập hover cho nút */
        .edit-btn:hover {
            background-color: #45a049; /* Màu nền khi di chuột vào */
        }
        .gray-background {
            background-color: #f2f2f2;
        }
        select {
        padding: 5px; /* Khoảng cách bên trong của combobox */
        border: 1px solid #ccc; /* Đường viền của combobox */
        border-radius: 4px; /* Bo góc combobox */
        font-size: 16px; /* Cỡ chữ */
        width: 200px; /* Độ rộng của combobox */
        }

        /* Thiết lập kiểu cho các tùy chọn trong combobox */
        option {
            font-size: 16px; /* Cỡ chữ */
        }
        .submit{
            margin:5px;
            padding: 10px 12px;
            background-color: #fff;
        }
        .submit:hover{
            color:#fff;
            background-color:#333;
        }
        .error-message{
            color: red;
        }
        .success-message{
            color: blue;
            width: 50%;
            text-align: center;
            padding: 10px 12px;
            font-size: large;

        }

    </style>
</head>
<body>
    <h1>Sửa tài khoản</h1>
    <form action="/xuLyCapNhatTK" method="post">
        @csrf <!-- Sử dụng token CSRF protection trong Laravel -->
        <div class="error-message">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        @foreach ($data as $item)
            <input type="text" id="maTK" name="maTK" value="{{ $item->MaTaiKhoan }}" hidden><br>

            <label for="tentaikhoan">Tên tài khoản:</label>
            <input type="text" id="tentaikhoan" name="tentaikhoan" value="{{ $item->TenTaiKhoan }}" ><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="{{ $item->Email }}" readonly class="gray-background"><br>

            <label for="sdt">Số điện thoại:</label>
            <input type="text" id="sdt" name="sdt" value="{{ $item->SoDienThoai }}"><br>

            <label for="thoiGianTao">Thời gian tạo:</label>
            <input type="text" id="thoiGianTao" name="thoiGianTao" value="{{ $item->ThoiGianTao }}"  readonly class="gray-background"><br>

            <label for="thoiGianSua">Thời gian sua:</label>
            <input type="text" id="thoiGianSua" name="thoiGianSua" value="{{ $item->ThoiGianSua }}"  readonly class="gray-background"><br>

            <label for="quyen">Quyền: </label>
            <input type="text" id="quyen" name="quyen" value="{{ $item->Quyen }}"  readonly class="gray-background"><br>


        @endforeach

        <button type="submit" class="submit">Lưu</button>
    </form>
    <a href="{{ route('/') }}"><button class="submit">Trở lại</button></a>
    
    
</body>

</html>