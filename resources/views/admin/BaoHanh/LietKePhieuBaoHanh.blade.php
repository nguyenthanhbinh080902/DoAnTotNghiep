@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê phiếu bảo hành
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
            </span>
          </div>
        </div>
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
              <th>Tên khách hàng</th>
              <th>Số điện thoại</th>
              <th>Thời gian lập phiếu</th>
              <th>Ngày lập phiếu</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allPhieuBaoHanh as $key => $phieuBaoHanh)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $phieuBaoHanh->TenKhachHang }}</td>
              <td>{{ $phieuBaoHanh->SoDienThoai }}</td>
              <td>{{ date('s:i:H', strtotime($phieuBaoHanh->ThoiGianTao)) }}</td>
              <td>{{ date('d M Y', strtotime($phieuBaoHanh->ThoiGianTao)) }}</td>
              <td>
                <a href="{{ route('/TrangChiTietPhieuBaoHanh', $phieuBaoHanh->order_code) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: purple; margin-bottom: 15px" class="fa-solid fa-eye"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              {{ $allPhieuBaoHanh->links('vendor.pagination.bootstrap-4') }}
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection