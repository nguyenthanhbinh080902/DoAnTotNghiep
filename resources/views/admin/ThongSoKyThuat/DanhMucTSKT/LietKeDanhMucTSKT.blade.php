@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê danh mục thông số kỹ thuật
      </div>
      <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <form action="{{Route('tim-kiem-dmtskt')}}" method="get">
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
              <th>Tên danh mục TSKT</th>
              <th>Thuộc danh mục</th>
              <th>Mô tả</th>
              <th>Trạng thái</th>
              <th style="width:100px;">Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allDanhMucTSKT as $key => $danhMucTSKT)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $danhMucTSKT->TenDMTSKT }}</td>
              <td>{{ $danhMucTSKT->DanhMuc->TenDanhMuc ?? 'None' }}</td>
              <td>{{ $danhMucTSKT->MoTa }}</td>
              <td><span class="text-ellipsis">
                <?php
                if ($danhMucTSKT->TrangThai == 1){
                ?>
                  <a href="" ><span
                    style="font-size: 28px; color: green; content: \f164" class="fa-solid fa-thumbs-up"></span></a>
                <?php
                }else{
                ?>
                  <a href="" ><span
                    style="font-size: 28px; color: red; ; content: \f164" class="fa-thumb-styling-down fa fa-thumbs-down"></span></a>
                <?php
                }
                ?>
              </span></td>
              <td>
                <a href="{{ route('/TrangSuaDanhMucTSKT', $danhMucTSKT->MaDMTSKT) }}"><i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;"
                    class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn có muốn vô hiệu hóa {{ $danhMucTSKT->TenDMTSKT }} không?')" href="{{ route('/XoaDanhMucTSKT', [$danhMucTSKT->MaDMTSKT]) }}">
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
                @if ($allDanhMucTSKT instanceof \Illuminate\Pagination\LengthAwarePaginator)

                    {{ $allDanhMucTSKT->links('vendor.pagination.bootstrap-4') }}
                @endif

            </ul>
          </div>
      </div>
      </footer>
    </div>
</div>
@endsection
