@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật nhà cung cấp
            </header>
            <div class="panel-body">
                <div class="position-center">
                @php 
                    $user = session(('user'));
                    $quyen = $user['Quyen'];

                @endphp 
                @foreach ($data as $item)
                    <form role="form" id="from" action="/xuLySuaNCC" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="maNCC">Mã nhà cung cấp</label>  
                            <input class="form-control" type="text" id="maNCC" name="maNCC" value="{{ $item->MaNhaCungCap }}" readonly class="gray-background">
                        </div>
                        <div class="form-group">
                            <label for="tennhacungcap">Tên nhà cung cấp</label>
                            <input class="form-control" type="text" id="tennhacungcap" name="tennhacungcap" value="{{ $item->TenNhaCungCap }}">
                        </div>
                        @error('tennhacungcap')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="diachi">Địa chỉ</label>  
                            <input class="form-control" type="text" id="diachi" name="diachi" value="{{ $item->DiaChi }}" >    
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
                            <label for="sdt">Số điện thoại</label>                 
                            <input class="form-control" type="number" id="sdt" name="sdt" value="{{ $item->SoDienThoai }}">
                        </div>
                        @error('sdt')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email</label>                   
                            <input class="form-control" type="text" id="email" name="email" value="{{ $item->Email }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <div class="form-group" style="{{ $quyen != 'Quản trị viên cấp cao' ? 'display: none;' : '' }}">
                            <label for="">Trạng thái</label>
                            <select name="trangThai" class="form-control input-lg m-bot15">
                                <option value="0" {{ $item->TrangThai == '0' ? 'selected' : '' }}>Ngừng hợp tác</option>
                                <option value="1" {{ $item->TrangThai == '1' ? 'selected' : '' }}>Hợp tác</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </form>
                @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection