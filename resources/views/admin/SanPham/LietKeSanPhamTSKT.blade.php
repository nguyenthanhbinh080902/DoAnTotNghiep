@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Chi tiết thông số kĩ thuật của sản phẩm
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
              <th>Thuộc danh mục TSKT</th>
              <th>Tên thông số kỹ thuật</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allSanPhamTSKT as $key => $valueSanPhamTSKT)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $valueSanPhamTSKT->ThongSoKyThuat->DanhMucTSKT->TenDMTSKT }}</td>
              <td>{{ $valueSanPhamTSKT->ThongSoKyThuat->TenTSKT }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
