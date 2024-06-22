

@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Báo cáo xuất nhập tồn
        </div>
        <div class="row w3-res-tb">
                <div class="col-sm-4 m-b-xs">
                </div>
                <div class="col-sm-7">
                
                </div>
                <div class="col-sm-1">
                    
                </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light table-bordered" style="text-align:center;">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th colspan="10" style="text-align:center;">Thời gian: {{ date_format(date_create($tgDau), 'd/m/Y') }} - {{ date_format(date_create($tgCuoi), 'd/m/Y') }}</th>
                    </tr>
                    <tr >
                        <th rowspan="2" >Mã sản phẩm</th>
                        <th rowspan="2" style="text-align:center;">Tên sản phẩm</th>
                        <th rowspan="2">Tồn đầu kỳ</th>
                        <th colspan="3" style="text-align:center;">Nhập trong kỳ</th>
                        <th colspan="3" style="text-align:center;">Xuất trong kỳ</th>
                        <th colspan="3" style="text-align:center;">Tồn cuối kỳ</th>
                    </tr>
                    <tr>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Thành tiền</th>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Thành tiền</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Thành tiền</th>
                    </tr>
                    
                </thead>
                <tbody>
                    @php
                        $tongNhap = 0;
                        $tongXuat = 0;
                        $tongSoNhap = 0;
                        $tongSoXuat = 0;
                        $tongSoTon = 0;
                        $tongGiaTri = 0;
                    @endphp
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item['maSanPham'] }}</td> 
                            <td>{{ $item['tenSanPham'] }}</td> <!-- Giả sử tên mặt hàng là 'ten' -->
                            @php 
                                $sltd = $item['soLuongSP'] + $item['tongSLXuat'] - $item['tongSLNhap'];
                                $thanhTienN = $item['tongSLNhap'] * $item['giaNhap'];
                                $thanhTienX = $item['tongSLXuat'] * $item['giaBan'];
                                $thanhTienT = $item['soLuongSP'] * $item['giaBan'];
                                $tongNhap += $thanhTienN;
                                $tongGiaTri += $thanhTienT;
                                $tongXuat += $thanhTienX;
                                $tongSoNhap += $item['tongSLNhap'];
                                $tongSoXuat += $item['tongSLXuat'];
                                $tongSoTon += $item['soLuongSP'];
                                
                            @endphp
                            <td>{{ $sltd }}</td>
                            <td>{{ $item['tongSLNhap'] }}</td>
                            <td>{{ $item['giaNhap'] }}</td>
                            <th>{{ $thanhTienN }}</th>
                            <td>{{ $item['tongSLXuat'] }}</td>
                            <td>{{ $item['giaBan'] }}</td>
                            <th>{{ $thanhTienX }}</th>
                            <td>{{ $item['soLuongSP'] }}</td>
                            <td>{{ $item['giaBan'] }}</td>
                            <td>{{ $thanhTienT }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Cộng</td>
                        <td>{{ $tongSoNhap }}</td>
                        <td></td>
                        <td>{{ $tongNhap }}</td>
                        <td>{{ $tongSoXuat }}</td>
                        <td></td>
                        <td>{{ $tongXuat }}</td>
                        <td>{{ $tongSoTon }}</td>
                        <td></td>
                        <td>{{ $tongGiaTri }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        
    </div>
    <a href="{{ route('xemBaoCao') }}" style="margin: 5px"><button class="btn btn-info">Quay lại</button></a>
    <form action="{{ route('luuFile') }}" method="POST">
        @csrf 
        <input type="hidden" name="dataSP" value="{{ $data }}">
        <input type="hidden" name="tgDau" value="{{ $tgDau }}">
        <input type="hidden" name="tgCuoi" value="{{ $tgCuoi }}">
        <button type="submit" style="margin: 5px" class="btn btn-info">Xuất file</button>
    </form>
</div>



@endsection