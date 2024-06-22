@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê danh mục bài viết
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <form action="{{Route('timKiemDMBV')}}" method="get">

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
              <th>Tên danh mục bài viết</th>
              <th>Trạng thái</th>
              <th>Mô tả</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allDanhMucBV as $key => $danhMucBV)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $danhMucBV->TenDanhMucBV }}</td>
              <td><span class="text-ellipsis">
                @php
                if ($danhMucBV->TrangThai == 1){
                @endphp
                  <a href="{{ route('/KoKichHoatDanhMucBV', $danhMucBV->MaDanhMucBV) }}" ><span
                    style="font-size: 28px; color: green; content: \f164" class="fa-solid fa-toggle-on"></span></a>
                @php
                }else{
                @endphp
                  <a href="{{ route('/KichHoatDanhMucBV', $danhMucBV->MaDanhMucBV) }}" ><span
                    style="font-size: 28px; color: red; ; content: \f164" class="fa-solid fa-toggle-off"></span></a>
                @php
                }
                @endphp
              </span></td>
              <td>{{ $danhMucBV->MoTa }}</td>
              <td>
                <a href="{{ route('/TrangSuaDanhMucBV', $danhMucBV->MaDanhMucBV) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;" class="fa fa-pencil-square-o text-success text-active"></i>
                </a>
{{--                <a onclick="return confirm('Bạn có muốn xóa danh mục bài viết {{ $danhMucBV->MaDanhMucBV }} không?')" href="{{ route('/XoaDanhMucBV', [$danhMucBV->MaDanhMucBV]) }}">--}}
{{--                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red; margin-top: 10px" class="fa fa-times text-danger text"></i>--}}
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
                @if ($allDanhMucBV instanceof LengthAwarePaginator)
                    {{ $allDanhMucBV->links('vendor.pagination.bootstrap-4') }}
                @endif
            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
