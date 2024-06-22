@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê báo cáo doanh thu
      </div>
      <div class="panel-body">
        <div class="position-center">
          <form method="POST" action="{{ Route('/BaoCaoDoanhThuTheoDate') }}">
            {{ csrf_field() }}
            <div class="form-group col-sm-3">
              <label for="exampleInputEmail1">Lọc từ ngày</label>
              <input type="text" name="from_date" id="datepicker3" class="form-control" >
            </div>
            <div class="form-group col-sm-3">
              <label for="exampleInputEmail1">Lọc đến ngày</label>
              <input type="text" name="to_date" id="datepicker4" class="form-control" >
            </div>
            <div class="form-group col-sm-3">
                <label for="TrangThai">Chọn lọc theo mục</label>
                <select id="TrangThaiBaoCao" name="TrangThaiBaoCao" class="form-control">
                  <option value="">---Chọn---</option>
                  <option value="7ngay">7 ngày qua</option>
                  <option value="thangtruoc">tháng trước</option>
                  <option value="thangnay">tháng ngày</option>
                  <option value="3thangtruoc">3 tháng trước</option>
                  <option value="365ngayqua">365 ngày qua</option>
                </select>
            </div>
            <button type="submit" class="btn btn-info" style="margin-top: 22px">Lọc kết quả</button>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Hình ảnh</th>
              <th>Tên sản phẩm</th>
              <th>Số lượng bán</th>
              <th>Giá sản phẩm</th>
              <th>Thành tiền</th>
            </tr>
          </thead>
          <tbody>
            @php
              $count = 1;
            @endphp
            @foreach ($chart_data as $key => $value)
              @foreach ($allSanPham as $key2 => $sanPham )
                @if ($sanPham->MaSanPham == $value['MaSanPham'])
                <tr>
                  <td>{{ $count }}</td>
                  <td><img src="{{ asset('upload/sanPham/'.$sanPham->HinhAnh) }}" height="100px" width="150px"></td>
                  <td>{{ $sanPham->TenSanPham }}</td>
                  <td>{{ $value['SoLuong'] }}</td>
                  <td>{{ number_format($value['GiaSanPham'], 0, '', '.') }} đ</td>
                  <td>{{ number_format($value['SoLuong'] * $value['GiaSanPham'] , 0, '', '.') }} đ </td>
                </tr>
                @php
                  $count ++;
                @endphp
                @endif
              @endforeach
            @endforeach
            <tr>
              <td colspan="6">
                @php
                  $doanhThu = 0;
                  foreach($chart_data as $key => $value){
                    $doanhThu += $value['GiaSanPham']*$value['SoLuong'];
                  }

                  $loiNhuan = 0;
                  foreach($chart_data as $key => $value){
                    foreach($allChiTietPhieuNhap as $key => $phieuNhap){
                      if($value['MaSanPham'] == $phieuNhap->MaSanPham){
                        $loiNhuan += ($value['GiaSanPham'] - $phieuNhap->GiaSanPham)*$value['SoLuong'];
                      }else{
                        $loiNhuan += $value['GiaSanPham']*(100-95)/100*$value['SoLuong'];
                      }
                    }
                  }
                @endphp
                Doanh Thu: {{ number_format($doanhThu, 0,',','.').'đ' }}<br> 
                Lợi nhuận: {{ number_format($loiNhuan, 0,',','.').'đ' }}<br>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <form action="{{ route('xuatFileBCDT') }}" method="GET">
        @csrf 
        <button type="submit" class="btn btn-info">Xuất file</button>
    </form>
</div>
@endsection