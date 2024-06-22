@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Lập phiếu xuất 
            </header>
            @php
                $user = Session::get('user');
            @endphp 
            <div class="panel-body">
                <div class="position-center">

                <form id="phieuNhapForm" role="form" action="{{ route('xuLyLapPX') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Mã phiếu</label>
                        <input type="text" class="form-control" name="maPhieu" value="{{ $maPX }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Người lập phiếu</label>
                        <input type="text" class="form-control" name="nguoiLap" value="{{ $user['TenTaiKhoan'] }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Lý do xuất</label>
                        <select class="form-control input-lg m-bot15" id="lyDoXuat" name="lyDoXuat">
                            <option value="XuatBan">Xuất bán</option>
                            <option value="Khac">Khác</option>
                        </select>
                    </div>
                    <div class="form-group" id="maDHGroup">
                        <label for="">Mã đơn hàng</label>
                        <input type="text" class="form-control" name="maDH">
                    </div>
                    <div class="form-group hidden" id="lyDoKhacGroup">
                        <label for="">Lý do khác</label>
                        <input type="text" class="form-control" name="lyDoKhac">
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Tổng số lượng</label>
                        <input type="text" class="form-control" name="tongSoLuong" value="0" readonly>
                    </div> -->

                    <button type="submit" class="btn btn-info update-btn">Lập phiếu xuất</button>
                </form>

                <form id="phieuNhapCTForm" role="form" action="{{ route('xuLyLapPXCT1') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Mã phiếu xuất:</label>
                        <input type="text" class="form-control" name="maPX" value="{{$maPX}}" readonly>
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
                        <select class="form-control @error('MaSanPham') is-invalid @enderror" id="MaSanPham" name="maSP" style="width:100%"></select>
                    </div>
                    @error('maSP')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Số lượng</label>
                        <input type="number" class="form-control" name="soLuong" >
                    </div>
                    @error('soLuong')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
                </form>
                
                
                <div class="table-responsive">
                    <table id="phieuNhapTable" class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <!-- <th>Mã phiếu nhập chi tiết</th> -->
                                <th>Mã phiếu nhập</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="control" style="display:none; margin:5px;">
                    <a href="{{ route('luuPX', ['id' => $maPX]) }}"><button class="btn btn-info">Lưu</button></a>
                    <a href="{{ route('xoaPX', ['id' => $maPX]) }}"><button class="btn btn-info">Hủy</button></a>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Xử lý form phiếu nhập
    $('#phieuNhapForm').on('submit', function(e) {
        e.preventDefault();  // Ngăn chặn hành động submit mặc định của form

        var formData = $(this).serialize();  // Lấy dữ liệu từ form

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Lập phiếu xuất thành công',
                            showConfirmButton: false,
                            timer: 800
                        });

                    $('#phieuNhapForm').hide();
                    $('#phieuNhapCTForm').show();
                    $('#control').show();
                } else {
                    Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Lập phiếu xuất thất bại: ' + data.message,
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

    // Xử lý form chi tiết phiếu nhập
    $('#phieuNhapCTForm').on('submit', function(e) {
        e.preventDefault();  // Ngăn chặn hành động submit mặc định của form

        var formData = $(this).serialize();  // Lấy dữ liệu từ form

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 800
                        });
                    $('#MaSanPham').val(null).trigger('change');
                    
                    var kt = false;

                    $('#phieuNhapTable tbody tr').each(function() {
                        var row = $(this);
                        var maSP = row.find('td:nth-child(2)').text();
                        if (maSP === data.maSP) {
                            row.find('td:nth-child(3)').text(data.soLuong);
                            kt = true;
                            return false;  // Thoát khỏi vòng lặp each
                        }
                    });

                    if (!kt) {
                    
                        var newRow = `
                            <tr>
                                <td>${data.maPX}</td>
                                <td>${data.maSP}</td>
                                <td>${data.soLuong}</td>
                            </tr>
                        `;

                        // Thêm hàng mới vào bảng
                        $('#phieuNhapTable tbody').append(newRow);
                    }

                    // Reset form chi tiết phiếu nhập
                    $('#phieuNhapCTForm')[0].reset();
                } else {
                    Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Thêm sản phẩm thất bại: ' + data.message,
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

    // Ẩn form chi tiết phiếu nhập lúc đầu
    $('#phieuNhapCTForm').hide();

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