@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê tài khoản
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-5">
                <form action="{{ Route('timKiemTK') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                        </span>
                        <span class="input-group-btn">
                            <a class="btn btn-sm btn-default" href="{{ Route('lietKeTK') }}">Xem tất cả</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>     
                        <th>STT</th>                
                        <th>Tên tài khoản</th>
                        <th>Email</th>
                        <th>SDT</th>                       
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Thời gian tạo</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $tk)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $tk->TenTaiKhoan }}</td>
                            <td>{{ $tk->Email }}</td>
                            <td>{{ $tk->SoDienThoai }}</td>
                            <td>{{ $tk->Quyen }}</td>
                            @php 
                                if($tk->TrangThai == 1){
                                    $tt = 'Kích hoạt'; 
                                }else{
                                    $tt = 'Vô hiệu hóa'; 
                                }
                            @endphp
                            <td>{{ $tt }}</td>
                            <td>{{ $tk->ThoiGianTao }}</td>
                            <td>
                                <a href="{{ route('suaTK', ['id' => $tk->MaTaiKhoan]) }}"><i style="font-size: 20px; padding: 5px; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                                <a onclick="return confirm('Bạn có muốn xóa tài khoản {{ $tk->TenTaiKhoan }} không?')" href="{{ route('xoaTK', ['id' => $tk->MaTaiKhoan]) }}"><i style="font-size: 20px; padding: 5px; color: red;" class="fa fa-times text-danger text"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <footer class="panel-footer">
                <div class="row">
                <div class="col-sm-5 text-center">
                </div>
                <div class="col-sm-7 text-right text-center-xs">                
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
                </div>
            </footer>
        </div>
    </div>
</div>
@endsection  