@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
        <div class="panel-heading">
            Chi Tiết Chương Trình Giảm Giá
        </div>
        <div class="card " style="margin: 5%">
            <div class="card-header">
                <p><strong>Tên chương trình giảm giá:</strong> {{ $discountProgram->TenCTGG }}</p>
            </div>
            <div class="card-body">
                <p><strong>Slug:</strong> {{ $discountProgram->SlugCTGG }}</p>
                <p><strong>Hình Ảnh:</strong></p>
                <img style="margin: 3% 5%" src="{{ asset($discountProgram->HinhAnh) }}" alt="{{ $discountProgram->TenCTGG }}" width="200">
                <p><strong>Mô Tả:</strong> <div style="margin-left: 5%">{!! $discountProgram->MoTa !!}</div> </p>
                <p><strong>Trạng Thái:</strong> {{ $discountProgram->TrangThai ? 'Hiển thị' : 'Ẩn' }}</p>
                <p><strong>Ngày Tạo:</strong> {{ $discountProgram->ThoiGianTao }}</p>
                <p><strong>Thời gian bắt đầu:</strong> {{ $discountProgram->ThoiGianBatDau }}</p>
                <p><strong>Thời gian kết thúc:</strong> {{ $discountProgram->ThoiGianKetThuc }}</p>

                <div class="panel-heading" style="margin-top: 5%">
                    Sản Phẩm trong Chương Trình Giảm Giá
                </div>
                <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Hình Ảnh</th>
                        <th>Giá</th>
                        <th>Phần Trăm Giảm</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discountProgram->SanPham as $product)
                        <tr>
                            <td>{{ $product->TenSanPham }}</td>
                            <td><img src="{{ asset('upload/sanPham/'.$product->HinhAnh) }}" alt="{{ $product->TenSanPham }}" width="100"></td>
                            <td>{{ $product->GiaSanPham }}</td>
                            <td>{{ $product->pivot->PhanTramGiam }}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
{{--                <footer class="panel-footer">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-5 text-center">--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-7 text-right text-center-xs">--}}
{{--                            <ul class="pagination pagination-sm m-t-none m-b-none">--}}
{{--                                @if ($discountProgram instanceof \Illuminate\Pagination\LengthAwarePaginator)--}}
{{--                                    {{ $discountProgram->links('vendor.pagination.bootstrap-4') }}--}}
{{--                                @endif--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </footer>--}}
            </div>
            <div class="card-footer">
                <a style="margin-bottom: 5%" href="{{ route('/chuong-trinh-giam-gia') }}" class="btn btn btn-info">Quay lại danh sách</a>
            </div>
        </div>
    </div>
    </div>
@endsection
