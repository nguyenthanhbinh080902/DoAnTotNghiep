@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê phiếu xuất
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-4 m-b-xs">
                </div>
                <div class="col-sm-3">
                    
                    <form action="{{ route('phieu-xuat.loc') }}" method="get">
                        <div class="input-group">  
                            <input type="month" class="input-sm form-control" name="thoiGian" value="{{old('thoiGian')}}"> 
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Lọc</button>
                            </span>  
                        </div>
                    </form>
                    
                </div>
                <div class="col-sm-5">
                    <form action="{{ Route('timKiemPX') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{ Route('xemPX') }}">Xem tất cả</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã phiếu xuất</th>
                            <th>Người lập phiếu</th>
                            <th>Lý do xuất</th>
                            <th>Mã đơn hàng</th>
                            <th>Trạng thái</th>                           
                            <th >Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>{{ $i->MaPhieuXuat }}</td>
                                <td>{{ $i->TenTaiKhoan }}</td>
                                <td>{{ $i->LyDoXuat }}</td>
                                <td>{{ $i->MaDonHang }}</td>
                                @php 
                                    if($i->soCTPX == 0){
                                        $trangthai = "Không có sản phẩm được xuất!";
                                    }else{
                                        if($i->TrangThai == 0){
                                            $trangthai = "Chưa xác nhận";
                                        }elseif($i->TrangThai == 1){
                                            $trangthai = "Đã xác nhận";
                                        }else{
                                            $trangthai = "";
                                        }
                                    }                                    
                                @endphp                                
                                <td class="{{ $i->soCTPX == 0 ? 'boi-mau' : '' }}">{{ $trangthai }}</td>                               
                                <td>
                                    <a href="{{ route('xemCT', ['id' => $i->MaPhieuXuat]) }}">
                                    <i style="font-size: 20px; padding: 5px; color: purple;" class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suaPX', ['id' => $i->MaPhieuXuat]) }}"><i style="font-size: 20px; padding: 5px; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    @if ($i->TrangThai == 0)
                                        <a onclick="return confirm('Bạn có muốn xóa phiếu xuất {{ $i->MaPhieuXuat }} không?')" href="{{ route('xoaPX', [$i->MaPhieuXuat]) }}"><i style="font-size: 20px; padding: 5px; color: red;" class="fa fa-times text-danger text"></i></a>
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
