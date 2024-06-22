@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê phiếu trả hàng
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-5">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{ Route('xemPTH') }}">Xem tất cả</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã phiếu trả hàng</th>
                            <th>Người lập phiếu</th>
                            <th>Nhà cung cấp</th>
                            <th>Mã phiếu nhập</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $pth)
                            <tr class="row-clickable" data-id="{{ $pth->MaPhieuTraHang }}">
                                <td>{{ $pth->MaPhieuTraHang }}</td>
                                <td>{{ $pth->TenTaiKhoan }}</td>
                                <td>{{ $pth->TenNhaCungCap }}</td>
                                <td>{{ $pth->MaPhieuNhap }}</td>
                                <td>{{ $pth->TongTien }}</td>
                                @php
                                    if($pth->soCTPTH == 0){
                                        $trangthai = "Không có sản phẩm được trả!";
                                    }else{
                                        if($pth->TrangThai == 0){
                                            $trangthai = "Chưa xác nhận";
                                        }elseif($pth->TrangThai == 1){
                                            $trangthai = "Đã xác nhận";
                                        }else{
                                            $trangthai = "";
                                        }
                                    }
                                @endphp 
                                <td class="{{ $pth->soCTPTH == 0 ? 'boi-mau' : '' }}">{{ $trangthai }}</td>
                                
                                <td>
                                    <a href="{{ route('xemCTPTH', ['id' => $pth->MaPhieuTraHang]) }}">
                                    <i style="font-size: 20px; padding: 5px; color: purple;" class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suaPTH', ['id' => $pth->MaPhieuTraHang]) }}"><i style="font-size: 20px; padding: 5px; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    @if ($pth->TrangThai == 0)
                                        <a onclick="return confirm('Bạn có muốn xóa danh mục {{ $pth->MaPhieuTraHang }} không?')" href="{{ route('xoaPTH', [$pth->MaPhieuTraHang]) }}"><i style="font-size: 20px; padding: 5px; color: red;" class="fa fa-times text-danger text"></i></a>
                                    @endif
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
