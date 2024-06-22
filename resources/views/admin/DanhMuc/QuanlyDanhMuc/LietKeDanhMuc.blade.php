@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê danh mục sản phẩm
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-4">
            <form action="{{Route('timKiemLSP')}}" method="get">
              <div class="input-group">
                <input type="text" name="TuKhoa" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                  <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </span>
                  <span class="input-group-btn">
                          <a class="btn btn-sm btn-default" href="{{ Route('/TrangLietKeDanhMuc') }}">Xem tất cả</a>
                  </span>
              </div>
            </form>
        </div>
          <div class="col-sm-2"></div>
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
              <th>Slug</th>
              <th>Mô tả</th>
              <th>Danh mục cha</th>
              <th>Trạng thái</th>
              <th style="width:100px">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allDanhMuc as $key => $danhMuc)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $danhMuc->TenDanhMuc }}</td>
              <td>{{ $danhMuc->SlugDanhMuc }}</td>
              <td>{{ $danhMuc->MoTa }}</td>
              <td>
                @if ($danhMuc->DanhMucCha == 0)
                  <span style="color: red">Danh Mục cha</span>
                @else
                  {{-- @foreach ($allDanhMuc as $key => $value)
                    @if ($value->MaDanhMuc == $danhMuc->DanhMucCha)
                    <span style="color: rgb(25, 174, 25)">{{ $value->TenDanhMuc }}</span>
                    @endif
                  @endforeach --}}
                  @foreach ($allDanhMucCha as $key => $danhMucCha)
                    @if ($danhMuc->DanhMucCha == $danhMucCha->MaDanhMuc)
                    <span style="color: rgb(25, 174, 25)">{{ $danhMucCha->TenDanhMuc }}</span>
                    @endif
                  @endforeach
                @endif
              </td>
              <td><span class="text-ellipsis">
                <?php
                if ($danhMuc->TrangThai == 1){
                ?>
                  <a href="{{ route('/KoKichHoatDanhMuc', $danhMuc->MaDanhMuc) }}" ><span
                    style="font-size: 28px; color: green; content: \f164" class="fa-solid fa-thumbs-up"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{ route('/KichHoatDanhMuc', $danhMuc->MaDanhMuc) }}" ><span
                    style="font-size: 28px; color: red; ; content: \f164" class="fa-thumb-styling-down fa fa-thumbs-down"></span></a>
                <?php
                }
                ?>
              </span></td>
              <td>
                <a href="{{ route('/TrangSuaDanhMuc', $danhMuc->MaDanhMuc) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa danh mục {{ $danhMuc->TenDanhMuc }} không?')" href="{{ route('/XoaDanhMuc', [$danhMuc->MaDanhMuc]) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i></a>
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
                @if ($allDanhMuc instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $allDanhMuc->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
        </div>
      </footer>
    </div>
</div>
@endsection
