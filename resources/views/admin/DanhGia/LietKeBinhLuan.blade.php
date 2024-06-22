@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê bình luận bài viết
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <form action="{{Route('timKiemBinhLuan')}}" method="get">

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
                    $message = Session::get('status');
                    if ($message) {
                        echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$message.'</span>';
                        Session::put('message', null);
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Email</th>
                        <th>Tên bài viết</th>
                        <th>Hình ảnh</th>
                        <th>Nội dung bình luận</th>
                        <th>Trạng thái</th>
                        {{--              <th>Quản lý</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allBinhLuan as $key => $binhLuan)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $binhLuan->Email }}</td>
                            <td>{{ $binhLuan->BaiViet->TenBaiViet }}</td>
                            <td><img src="{{ asset('upload/BaiViet/'.$binhLuan->BaiViet->HinhAnh) }}" height="100px"
                                     width="150px"></td>
                            <td>{{ $binhLuan->NoiDung }}</td>
                            <td><span class="text-ellipsis">
                @php
                    if ($binhLuan->TrangThai == 1){
                @endphp
                  <a href="{{ route('/KoKichHoatBinhLuan', $binhLuan->MaBinhLuan) }}"><span
                          style="font-size: 28px; color: green; content: \f164"
                          class="fa-solid fa-toggle-on"></span></a>
                @php
                    }else{
                @endphp
                  <a href="{{ route('/KichHoatBinhLuan', $binhLuan->MaBinhLuan) }}"><span
                          style="font-size: 28px; color: red; ; content: \f164"
                          class="fa-solid fa-toggle-off"></span></a>
                @php
                    }
                @endphp
              </span></td>
                            {{--              <td>--}}
                            {{--                <a onclick="return confirm('Bạn có muốn xóa đánh giá này không?')" href="{{ route('/XoaBinhLuan', [$binhLuan->MaBinhLuan]) }}">--}}
                            {{--                    <i style="font-size: 28px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i>--}}
                            {{--                </a>--}}
                            {{--              </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            @if ($allBinhLuan instanceof LengthAwarePaginator)
                                {{ $allBinhLuan->links('vendor.pagination.bootstrap-4') }}
                            @endif
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
