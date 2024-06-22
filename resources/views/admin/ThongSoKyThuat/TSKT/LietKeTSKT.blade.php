@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê thông số kỹ thuật
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <form action="{{Route('timKiemTSKT')}}" method="get">
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
              <th>Tên thông số</th>
              <th>Slug</th>
              <th>Thuộc danh mục SP</th>
              <th>Thuộc danh mục TSKT</th>
              <th>Mô tả</th>
                <th>Trạng thái</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allThongSoKyThuat as $key => $value)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $value->TenTSKT }}</td>
              <td>{{ $value->SlugTSKT }}</td>
              <td>
                @foreach ($allDanhMucTSKT as $key => $danhMucTSKT)
                  @if ($danhMucTSKT->MaDMTSKT == $value->MaDMTSKT)
                    {{ $danhMucTSKT->DanhMuc->TenDanhMuc }}
                  @endif
                @endforeach
              </td>
              <td>{{ $value->DanhMucTSKT->TenDMTSKT }}</td>
              <td>{{ $value->MoTa }}</td>
                @if($value->TrangThai == 1)
                    <td style="color: green">Hiển thị</td>
                @else
                    <td style="color: orange">Ẩn</td>
                @endif
              <td>
                <a href="{{ route('/TrangSuaTSKT', $value->MaTSKT) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;"
                    class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa thông số kỹ thuật này không?')" href="{{ route('/XoaTSKT', [$value->MaTSKT]) }}">
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
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
                @if ($allThongSoKyThuat instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $allThongSoKyThuat->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
