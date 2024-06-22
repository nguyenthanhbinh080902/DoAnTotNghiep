@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật tài khoản
            </header>
            <div class="panel-body">
                <div class="position-center">

                @foreach ($data as $item)
                    <form role="form" id="from" action="{{Route('xuLySuaTK')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="maTK">Mã tài khoản</label>  
                            <input class="form-control" type="text" id="maTK" name="maTK" value="{{ $item->MaTaiKhoan }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tentaikhoan">Tên nhà cung cấp</label>
                            <input class="form-control" type="text" id="tentaikhoan" name="tentaikhoan" value="{{ $item->TenTaiKhoan }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>                   
                            <input class="form-control" type="text" id="email" name="email" value="{{ $item->Email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sdt">Số điện thoại</label>                 
                            <input class="form-control" type="text" id="sdt" name="sdt" value="{{ $item->SoDienThoai }}">
                        </div>
                        @error('sdt')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="">Vai trò</label>             
                            <select id="quyen" class="form-control input-lg m-bot15" name="quyen">
                            @if(!empty($quyen))
                                @foreach ($quyen as $i)
                                    <option value="{{ $i->TenPhanQuyen }}" {{ $item->Quyen == $i->TenPhanQuyen ? 'selected' : '' }}>{{ $i->TenPhanQuyen }}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <select name="trangThai" class="form-control input-lg m-bot15">
                                <option value="0" {{ $item->TrangThai == '0' ? 'selected' : '' }}>Vô hiệu hóa</option>
                                <option value="1" {{ $item->TrangThai == '1' ? 'selected' : '' }}>Kích hoạt</option>
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