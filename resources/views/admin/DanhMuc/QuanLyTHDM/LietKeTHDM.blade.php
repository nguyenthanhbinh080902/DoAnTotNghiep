@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê thương hiệu thuộc danh mục
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
          $message = Session::get('status');
          if ($message) {
              echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$message.'</span>';
              Session::put('message', null);
          }
        ?>
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên danh mục</th>
              <th>Danh mục cha</th>
              <th>Tên thương hiệu</th>
              <th>Hình ảnh thương hiệu</th>
              <th style="width:100px">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allTHDM as $key => $value)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $value->DanhMuc->TenDanhMuc }}</td>
              <td>
                @if ($value->DanhMuc->DanhMucCha == 0)
                  <span style="color: red">Danh Mục cha</span>
                @else
                  @foreach ($allDanhMuc as $key => $danhMuc)
                    @if ($value->DanhMuc->DanhMucCha == $danhMuc->MaDanhMuc)
                    <span style="color: rgb(25, 174, 25)">{{ $danhMuc->TenDanhMuc }}</span>
                    @endif
                  @endforeach
                @endif
              </td>
              <td>{{ $value->ThuongHieu->TenThuongHieu }}</td>
              <td><img src="{{ asset('upload/ThuongHieu/'.$value->ThuongHieu->HinhAnh) }}" height="100px" width="150px"></td>
              <td>
                <a href="{{ route('/trang-sua-thdm', $value->MaTHDM) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa danh mục không?')" href="{{ route('/xoa-thdm', $value->MaTHDM) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-5 text-center">
          </div>
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              {{ $allTHDM->links('vendor.pagination.bootstrap-4') }}
            </ul>
          </div>
        </div>
      </footer>
    </div>
</div>
@endsection