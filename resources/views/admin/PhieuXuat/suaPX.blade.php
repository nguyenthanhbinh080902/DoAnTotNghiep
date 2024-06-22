@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật phiếu xuất 
            </header>
            <div class="panel-body">
                <div class="position-center">

                @php 
                    $user = session(('user'));
                    $quyen = $user['Quyen'];

                @endphp 
                    <form role="form" action="{{ Route('suaPXP') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Mã phiếu</label>
                            <input type="text" class="form-control" name="maPX" value="{{ $px->MaPhieuXuat }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Người lập phiếu</label>
                            <input type="text" class="form-control" name="nguoiLap" value="{{ $px->TenTaiKhoan }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Lý do xuất</label>
                            <select class="form-control input-lg m-bot15" id="lyDoXuat" name="lyDoXuat">
                                <option value="XuatBan" {{ $px->LyDoXuat == 'Xuất bán' ? 'selected' : ''}}>Xuất bán</option>
                                <option value="Khac" {{ $px->LyDoXuat != 'Xuất bán' ? 'selected' : ''}}>Khác</option>
                            </select>
                        </div>
                        <div class="form-group" id="maDHGroup">
                            <label for="">Mã đơn hàng</label>
                            <input type="text" class="form-control" name="maDH" value="{{ $px->MaDonHang }}">
                        </div>
                        <div class="form-group hidden" id="lyDoKhacGroup">
                            <label for="">Lý do</label>
                            <input type="text" class="form-control" name="lyDoKhac" value="{{ $px->LyDoXuat }}">
                        </div> 


                        <div class="form-group">
                            <label for="">Tổng số lượng</label>
                            <input type="text" class="form-control" name="tongSL" value="{{ $px->TongSoLuong }}" readonly>
                        </div>
                        <div class="form-group" style="{{ $quyen != 'Quản trị viên cấp cao' ? 'display: none;' : '' }}">
                            <label for="">Trạng thái</label>
                            <input type="hidden" id="mySelect1" class="form-control" name="trangThaiTruoc" value="{{ $px->TrangThai }}">
                            <select name="trangThai" id="mySelect" class="form-control input-lg m-bot15">
                                <option value="0" {{ $px->TrangThai == '0' ? 'selected' : '' }}>Chưa xác nhận</option>
                                <option value="1" {{ $px->TrangThai == '1' ? 'selected' : '' }}>Xác nhận</option>
                            </select>
                        </div>
                        @error('trangThai')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" name="" class="btn btn-info">Lưu</button>
                        
                    </form>
                    <form id="myLink3" role="form" action="{{ route('xuLyLapPXCT') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <!-- <label for="">Mã phiếu xuất:</label> -->
                            <input type="hidden" class="form-control" name="maPXSua" value="{{$px->MaPhieuXuat}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Loại sản phẩm</label>
                            <select class="form-control input-lg m-bot15" id="loaiSP" name="loaiSP">
                                <option value="">Chọn loại sản phẩm</option>
                                @foreach($listLSP as $dm)
                                    <option value="{{ $dm->MaDanhMuc }}">{{ $dm->TenDanhMuc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="MaSanPham">Sản phẩm</label>
                            <select class="form-control  @error('MaSanPham') is-invalid @enderror" id="MaSanPham" name="maSP"
                            style="width: 100%;">
                            </select>
                        </div>
                        @error('maSP')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="">Số lượng</label>
                            <input type="number" class="form-control" name="soLuong" min="1" value="{{ old('soLuong') }}">
                        </div>
                        @error('soLuong')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-info">Thêm sản phẩm xuất?</button>
                    </form>
                    
                    
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                    <!-- <th>Mã phiếu nhập chi tiết</th> -->
                                    <th>Mã phiếu nhập</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th style="width:100px" id="myLink4">Quản lý</th>                  
                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($ctpx as $ct)

                                    <tr>
                                        <td>{{ $ct->MaPhieuXuat }}</td>
                                        <td>{{ $ct->TenSanPham }}</td>
                                        <td><input type="number" value="{{ $ct->SoLuong }}" id="soLuong_{{ $ct->MaCTPX }}"></td>

                                        <td id = "myLink">
                                            <a href="javascript:void(0);" class="update-btn" data-id="{{ $ct->MaCTPX }}">Cập nhật</a>
                                            <a onclick="return confirm('Bạn có muốn xóa sản phẩm {{ $ct->TenSanPham }} trong phiếu xuất không?')" href="{{ route('xoaCTPXS', ['id' => $ct->MaCTPX, 'maPX' => $px->MaPhieuXuat]) }}">
                                                <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>

function handleChange() {
    if ($('#mySelect').val() == '1') {
        $('[id^="myLink"]').hide();
    } else {
        if ($('#mySelect1').val() == '0'){
            $('[id^="myLink"]').show();
        }
        
    }
}

// Sử dụng sự kiện change và gọi hàm onChange
$(document).ready(function() {
    handleChange();
    $('#mySelect').change(handleChange);
});
</script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.update-btn').on('click', function() {
        var MaCTPX = $(this).data('id');
        var soLuong = $('#soLuong_' + MaCTPX).val();

        $.ajax({
            url: '{{ route('update.soluong-px') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                MaCTPX: MaCTPX,
                soLuong: soLuong,
            },
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Cập nhật thành công',
                            showConfirmButton: false,
                            timer: 800
                        });
                } else {
                    Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Cập nhật thất bại: ' + data.message,
                            showConfirmButton: true
                        });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: 'Bạn nhập thiếu thông tin!!!Mời bạn kiểm tra lại thông tin!!!',
                        showConfirmButton: true
                    });
            }
        });
    });
});
</script>
    <script>
        document.getElementById('lyDoXuat').addEventListener('change', function() {
            var selectedValue = this.value;
            var maDHGroup = document.getElementById('maDHGroup');
            var lyDoKhacGroup = document.getElementById('lyDoKhacGroup');

            if (selectedValue === 'XuatBan') {
                maDHGroup.classList.remove('hidden');
                lyDoKhacGroup.classList.add('hidden');
            } else if (selectedValue === 'Khac') {
                maDHGroup.classList.add('hidden');
                lyDoKhacGroup.classList.remove('hidden');
            }
        });

        // Initialize the form based on the default selected value
        document.getElementById('lyDoXuat').dispatchEvent(new Event('change'));
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            var selectedValues = {!! json_encode(old('MaSanPham')) !!};

            var selectedLoaiSP = '';

            $('#loaiSP').on('change', function() {
                selectedLoaiSP = $(this).val();
                $('#MaSanPham').val(null).trigger('change');
            });

            $('#MaSanPham').select2({
                placeholder: 'Chọn sản phẩm',
                allowClear: true,
                ajax: {
                    url: '{{ route("api.san-pham-pn") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // từ khóa tìm kiếm
                            loaiSP:selectedLoaiSP
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            // Khởi tạo lại giá trị đã chọn nếu có
            if (selectedValues) {
                $.ajax({
                    url: '{{ route("api.san-pham-pn") }}',
                    dataType: 'json',
                    data: {
                        ids: selectedValues // gửi các ID của sản phẩm để lấy thông tin
                    },
                    success: function (data) {
                        var selectedOptions = [];
                        $.each(data, function (index, item) {
                            selectedOptions.push({
                                id: item.id,
                                text: item.text
                            });
                            $('#MaSanPham').append(new Option(item.text, item.id, true, true)).trigger('change');
                        });
                    }
                });
            }
        });
    </script>
    
@endsection