@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê phí giao hàng
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <form action="{{Route('timKiemPhiGiaoHang')}}" method="get">

              <div class="input-group">
                <input type="text" name="TuKhoa" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                  <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </span>
              </div>
            </form>
        </div>
      </div>
      <div class="table-responsive">
        <?php
            $status = Session::get('status');
            if ($status) {
                echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$status.'</span>';
                Session::put('status', null);
            }
        ?>
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên thành phố / Tỉnh</th>
              <th>Tên quận / Huyện</th>
              <th>Tên xã phường / Thị trấn</th>
              <th>Thành tiền</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allPhiGiaoHang as $key => $phiGiaoHang)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $phiGiaoHang->TinhThanhPho->TenThanhPho }}</td>
              <td>{{ $phiGiaoHang->QuanHuyen->TenQuanHuyen }}</td>
              <td>{{ $phiGiaoHang->XaPhuongThiTran->TenXaPhuong }}</td>
              <td>{{ number_format($phiGiaoHang->SoTien, 0, '', '.') }} đ</td>
              <td>
                <a href="{{ route('/TrangSuaPhiGiaoHang', $phiGiaoHang->MaPhiGiaoHang) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa mục này không?')" href="{{ route('/XoaPhiGiaoHang', [$phiGiaoHang->MaPhiGiaoHang]) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i></a>
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
                @if ($allPhiGiaoHang instanceof \Illuminate\Pagination\LengthAwarePaginator)

                    {{ $allPhiGiaoHang->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
