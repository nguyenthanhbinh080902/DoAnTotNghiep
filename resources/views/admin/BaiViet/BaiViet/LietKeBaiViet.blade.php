@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê bài viết
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <form action="{{Route('timKiemBV')}}" method="get">

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
              <th>Tên bài viết</th>
              <th>Thuộc danh mục bài viết</th>
              <th>Hình ảnh</th>
              <th>Trạng thái</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allBaiViet as $key => $baiViet)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $baiViet->TenBaiViet }}</td>
              <td>{{ $baiViet->DanhMucBV->TenDanhMucBV }}</td>
              <td><img src="{{ asset('upload/BaiViet/'.$baiViet->HinhAnh) }}" height="100px" width="150px"></td>
              <td><span class="text-ellipsis">
                @php
                if ($baiViet->TrangThai == 1){
                @endphp
                  <a href="{{ route('/KoKichHoatBaiViet', $baiViet->MaBaiViet) }}" ><span
                    style="font-size: 28px; color: green; content: \f164" class="fa-solid fa-toggle-on"></span></a>
                @php
                }else{
                @endphp
                  <a href="{{ route('/KichHoatBaiViet', $baiViet->MaBaiViet) }}" ><span
                    style="font-size: 28px; color: red; ; content: \f164" class="fa-solid fa-toggle-off"></span></a>
                @php
                }
                @endphp
              </span></td>
              <td>
                <a href="{{ route('/TrangSuaBaiViet', $baiViet->MaBaiViet) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green; margin-bottom: 15px" class="fa fa-pencil-square-o text-success text-active"></i>
                </a>
{{--                <a onclick="return confirm('Bạn có muốn xóa bài viết {{ $baiViet->TenBaiViet }} không?')" href="{{ route('/XoaBaiViet', [$baiViet->MaBaiViet]) }}">--}}
{{--                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red; margin-bottom: 15px" class="fa fa-times text-danger text"></i>--}}
{{--                </a>--}}
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
                @if ($allBaiViet instanceof LengthAwarePaginator)
                    {{ $allBaiViet->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
