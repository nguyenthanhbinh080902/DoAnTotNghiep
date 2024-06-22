@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê chi tiết phiếu bảo hành
      </div>
      <div class="table-responsive">
        @php
            $status = Session::get('status');
            if ($status) {
                echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$status.'</span>';
                Session::put('status', null);
            }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên sản phẩm</th>
              <th>Hình ảnh</th>
              <th>Số lượng</th>
              <th>Thời gian bảo hành</th>
              <th>Thời gian bắt đầu</th>
              <th>Thời gian kết thúc</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allCTPBH as $key => $value)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $value->SanPham->TenSanPham }}</td>
              <td><img src="{{ asset('upload/sanPham/'.$value->SanPham->HinhAnh) }}" height="100px" width="150px"></td>
              <td>{{ $value->SoLuong }}</td>
              <td>{{ $value->SanPham->ThoiGianBaoHanh }}  tháng</td>
              <td>{{ date('d/M/Y', strtotime($value->ThoiGianBatDau)) }}</td>
              <td>{{ date('d/M/Y', strtotime($value->ThoiGianKetThuc)) }}</td>
              <td>
                <a href="{{ route('/TrangThemLichSuBaoHanh', $value->MaCTPBH) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: blue; margin-bottom: 15px" class="fa-solid fa-square-plus"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection