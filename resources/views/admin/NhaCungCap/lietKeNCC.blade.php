@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê nhà cung cấp
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-5">
                    <form action="{{ Route('timkiemNCC') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{ Route('lietKeNCC') }}">Xem tất cả</a>
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
                            <th>Tên nhà cung cấp</th>
                            <th>Địa chỉ</th>
                            <th>Tên người đại diện</th>
                            <th>SDT</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <!-- <th>Thời gian tạo</th> -->
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 0;
                        @endphp
                        @foreach ($data as $ncc)
                            <tr class="row-clickable" data-id="{{ $ncc->MaNhaCungCap }}">
                                @php
                                    $n++;
                                @endphp
                                <!-- <td>{{ $ncc->MaNhaCungCap }}</td> -->
                                <td>{{ $n }}</td>
                                <td>{{ $ncc->TenNhaCungCap }}</td>
                                <td>{{ $ncc->DiaChi }}</td>
                                <td>{{ $ncc->TenNguoiDaiDien }}</td>
                                <td>{{ $ncc->SoDienThoai }}</td>
                                <td>{{ $ncc->Email }}</td>
                                @php
                                    if($ncc->TrangThai == 1){
                                        $tt = 'Hợp tác';
                                    }else $tt = 'Ngừng hợp tác';
                                @endphp
                                <td>{{ $tt }}</td>
                                <!-- <td>{{ $ncc->ThoiGianTao }}</td> -->
                                <!-- <td>{{ $ncc->ThoiGianSua }}</td> -->
                                <td>
                                    <a href="{{ route('suaNCC', ['id' => $ncc->MaNhaCungCap]) }}"><i style="font-size: 20px; padding: 5px; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có muốn xóa nhà cung cấp {{ $ncc->TenNhaCungCap }} không?')" href="{{ route('xoaNCC', ['id' => $ncc->MaNhaCungCap]) }}"><i style="font-size: 20px; padding: 5px; color: red;" class="fa fa-times text-danger text"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        

    </div>
@endsection  