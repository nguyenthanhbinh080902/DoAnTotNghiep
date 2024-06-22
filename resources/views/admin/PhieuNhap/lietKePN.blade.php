@extends('admin_layout')
@section('admin_content')

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê phiếu nhập
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-4 m-b-xs">
                </div>
                <div class="col-sm-3">
                    
                    <form action="{{ route('phieu-nhap.loc') }}" method="get">
                        <div class="input-group">  
                            <input type="month" class="input-sm form-control" name="thoiGian" value="{{old('thoiGian')}}"> 
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Lọc</button>
                            </span>  
                        </div>
                    </form>
                    
                </div>
                <div class="col-sm-5">
                    <form action="{{ Route('timKiemPN') }}" method="get">
                        <div class="input-group">                                                 
                            <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem" >                           
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{ Route('xemPN') }}">Xem tất cả</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                @error('phieuTH')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã phiếu nhập</th>
                            <th>Người lập phiếu</th>
                            <th>Nhà cung cấp</th>
                            
                            <th>Tổng tiền</th>
                            <th>Số tiền nợ</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th >Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $pn)
                            <tr>
                                <td>{{ $pn->MaPhieuNhap }}</td>
                                <td>{{ $pn->TenTaiKhoan }}</td>
                                <td>{{ $pn->TenNhaCungCap }}</td>
                                
                                <td>{{ number_format($pn->TongTien, 0, '', '.') }} đ</td>
                                <td>{{ number_format($pn->TienNo, 0, '', '.') }} đ</td>
                                @php 
                                    if($pn->soChiTietPN == 0){
                                        $trangthai = "Không có sản phẩm được nhập!";
                                    }else{
                                        if($pn->TrangThai == 0){
                                        $trangthai = "Chưa xác nhận";
                                        }elseif($pn->TrangThai == 1){
                                            $trangthai = "Đã xác nhận";
                                            if($pn->TienNo == 0){
                                                $trangthai = "Đã thanh toán";
                                            }
                                        }else{
                                            $trangthai = "";
                                        }
                                    }
                                    

                                @endphp 
                                <td class="{{ $pn->soChiTietPN == 0 ? 'boi-mau' : '' }}"><p>{{ $trangthai }}</p></td>
                                <td>{{ $pn->ThoiGianTao }}</td>
                                <td>
                                    <a href="{{ route('xemCTPN', ['id' => $pn->MaPhieuNhap]) }}">
                                    <i style="font-size: 20px; padding: 5px; color: purple;" class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('suaPN', ['id' => $pn->MaPhieuNhap]) }}"><i style="font-size: 20px; padding: 5px; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    
                                    
                                    @if ($pn->TrangThai == 0)
                                        <a onclick="return confirm('Bạn có muốn xóa phiếu {{ $pn->MaPhieuNhap }} không?')" href="{{ route('xoaPN', [$pn->MaPhieuNhap]) }}"><i style="font-size: 20px; padding: 5px;  color: red;" class="fa fa-times text-danger text"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Thành công',
            //     text: '{{ session('success') }}',
            //     showConfirmButton: false,
            //     timer: 800
            // });
            @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 800
            });
            @endif
        });
    </script>
@endsection  
