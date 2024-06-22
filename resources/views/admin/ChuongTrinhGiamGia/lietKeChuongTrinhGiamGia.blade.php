@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liêt kê chương trình giảm giá
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-5">
                    <form action="{{ Route('/timKiemCTGG') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Tìm kiếm" name="timKiem">
                            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{ Route('/chuong-trinh-giam-gia') }}">Xem tất cả</a>
                            </span>
                        </div>
                    </form>

                </div>
            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Chương Trình</th>
                        <th>Slug</th>
                        <th>Hình Ảnh</th>
                        <th>Mô Tả</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th>Ngày Sửa</th>
                        <th>Quản lý</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discountPrograms as $key =>  $program)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $program->TenCTGG }}</td>
                            <td>{{ $program->SlugCTGG }}</td>
                            <td><img src="{{ $program->HinhAnh }}" alt="{{ $program->TenCTGG }}" width="50"></td>
                            <td>{!! $program->MoTa !!}</td>
                            @if($program->TrangThai == 1)
                                <td style="color: #0a8a0a">Hiển Thị</td>
                            @else
                                <td style="color: orange">Ẩn</td>
                            @endif
                            <td>{{ $program->ThoiGianTao }}</td>
                            <td>{{ $program->ThoiGianSua }}</td>
                            <td>
                                <a href="{{ route('/sua-chuong-trinh-giam-gia', $program->MaCTGG) }}"><i
                                        style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green;"
                                        class="fa fa-pencil-square-o text-success text-active"></i></a>
                                <a onclick="return confirm('Bạn có muốn ẩn chương trình giảm giá: {{ $program->TenCTGG }}  này không?')"
                                   href="{{ route('/xoa-chuong-trinh-giam-gia', [$program->MaCTGG]) }}"><i
                                        style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;"
                                        class="fa fa-times text-danger text"></i></a>
                                <a href="{{ route('/xem-chi-tiet-ctgg', $program->MaCTGG) }}">
                                    <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: purple; margin-bottom: 15px"
                                       class="fa-solid fa-eye"></i></a>
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
                            @if ($discountPrograms instanceof LengthAwarePaginator)
                                {{ $discountPrograms->links('vendor.pagination.bootstrap-4') }}
                            @endif
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
