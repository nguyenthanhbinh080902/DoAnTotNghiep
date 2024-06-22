@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê thương hiệu sản phẩm
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-4">
            <form action="{{route('timKiemThuongHieu')}}" method="get">

              <div class="input-group">
                <input type="text" name="TuKhoa" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                  <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </span>
                  <span class="input-group-btn">
                          <a class="btn btn-sm btn-default" href="{{ Route('/TrangLietKeThuongHieu') }}">Xem tất cả</a>
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
              <th>Tên thương hiệu</th>
              <th>Slug</th>
              <th>Mô tả</th>
              <th>Hình ảnh</th>
              <th>Trạng thái</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allThuongHieu as $key => $thuongHieu)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $thuongHieu->TenThuongHieu }}</td>
              <td>{{ $thuongHieu->SlugThuongHieu }}</td>
              <td>{{ $thuongHieu->MoTa }}</td>
              <td><img src="{{ asset('upload/ThuongHieu/'.$thuongHieu->HinhAnh) }}" height="100px" width="150px"></td>
              <td><span class="text-ellipsis">
                <?php
                if ($thuongHieu->TrangThai == 1){
                ?>
                  <a href="{{ route('/KoKichHoatThuongHieu', $thuongHieu->MaThuongHieu) }}" ><span
                    style="font-size: 28px; color: green; content: \f164" class="fa-solid fa-thumbs-up"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{ route('/KichHoatThuongHieu', $thuongHieu->MaThuongHieu) }}" ><span
                    style="font-size: 28px; color: red; ; content: \f164" class="fa-thumb-styling-down fa fa-thumbs-down"></span></a>
                <?php
                }
                ?>
              </span></td>
              <td>
                <a href="{{ route('/TrangSuaThuongHieu', $thuongHieu->MaThuongHieu) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;" class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn vô hiệu hóa thương hiệu {{ $thuongHieu->TenThuongHieu }} không?')" href="{{ route('/XoaThuongHieu', [$thuongHieu->MaThuongHieu]) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i></a>
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
                @if ($allThuongHieu instanceof \Illuminate\Pagination\LengthAwarePaginator)
                     {{ $allThuongHieu->links('vendor.pagination.bootstrap-4') }}

                @endif
            </ul>
          </div>
        </div>
      </footer>
    </div>
</div>
@endsection
