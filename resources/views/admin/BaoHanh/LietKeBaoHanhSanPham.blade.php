@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê thông tin bảo hành của sản phẩm
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
              <th>Tên sản phẩm</th>
              <th>Thuộc thương hiệu</th>
              <th>Thuộc danh mục</th>
              <th>Hình ảnh</th>
              <th>Thời gian bảo hành</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allSanPham as $key => $sanPham)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $sanPham->TenSanPham }}</td>
              <td>{{ $sanPham->ThuongHieu->TenThuongHieu }}</td>
              <td>{{ $sanPham->DanhMuc->TenDanhMuc }}</td>
              <td><img src="{{ asset('upload/sanPham/'.$sanPham->HinhAnh) }}" height="100px" width="150px"></td>
              <td>{{ $sanPham->ThoiGianBaoHanh .' tháng' ?? 'Không có thời hạn bảo hành' }}</td>
              <td>
                <a href="{{ route('/TrangSuaSanPham', $sanPham->MaSanPham) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green; margin-bottom: 15px" class="fa fa-pencil-square-o text-success text-active"></i>
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
              {{ $allSanPham->links('vendor.pagination.bootstrap-4') }}
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection