@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê sản phẩm
      </div>
      <div class="row w3-res-tb">
          <div class="col-sm-6">
          </div>
        <div class="col-sm-5">
              <form action="{{Route('tim-kiem-san-pham')}}" method="get">
                  <div class="input-group">
                        <input type="text" name="TuKhoa" class="input-sm form-control" placeholder="Tìm kiếm">
                          <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                        </span>
                      <span class="input-group-btn">
                          <a class="btn btn-sm btn-default" href="{{ Route('/TrangLietKeSanPham') }}">Xem tất cả</a>
                      </span>
                  </div>
              </form>
        </div>
          <div class="col-sm-2">
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
              <th>Giá</th>
                <th>Trạng Thái</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allSanPham as $key => $sanPham)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $sanPham->TenSanPham }}</td>
              <td>{{ $sanPham->ThuongHieu->TenThuongHieu ?? 'None' }}</td>
              <td>{{ $sanPham->DanhMuc->TenDanhMuc }}</td>
              <td><img src="{{ asset('upload/sanPham/'.$sanPham->HinhAnh) }}" height="100px" width="150px"></td>
              <td>{{ number_format($sanPham->GiaSanPham, 0, '', '.') }} đ</td>
                @if($sanPham->TrangThai == 1)
                    <td style="color: #0a8a0a!important;">Đang bán</td>
                @else
                    <td style="color: orange!important;">Ngừng bán</td>
                @endif

              <td>
                <a href="{{ route('/TrangSuaSanPham', $sanPham->MaSanPham) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green; margin-bottom: 15px" class="fa fa-pencil-square-o text-success text-active"></i>
                </a>
                <a onclick="return confirm('Bạn có muốn xóa {{ $sanPham->TenSanPham }} không?')" href="{{ route('/XoaSanPham', [$sanPham->MaSanPham]) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red; margin-bottom: 15px" class="fa fa-times text-danger text"></i>
                </a>
                <a href="{{ route('/TrangSanPhamTSKT', $sanPham->MaSanPham) }}">
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
                @if ($allSanPham instanceof \Illuminate\Pagination\LengthAwarePaginator)

                    {{ $allSanPham->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
