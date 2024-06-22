@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Lập phiếu nhập 
            </header>
            @php
                $user = Session::get('user');
            @endphp 
            <div class="panel-body">
                <div class="position-center">

                <form id="phieuNhapForm" role="form" action="{{ route('xuLyLapPN') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Mã phiếu</label>
                        <input type="text" class="form-control" name="maPhieu" value="{{ $maPN }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Người lập phiếu</label>
                        <input type="text" class="form-control" name="nguoiLap" value="{{ $user['TenTaiKhoan'] }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nhà cung cấp</label>
                        <select class="form-control input-lg m-bot15" id="maNCC" name="maNCC">
                            <option value="">Chọn một nhà cung cấp</option>
                            @foreach($listNCC as $ncc)
                                <option value="{{ $ncc->MaNhaCungCap }}">{{ $ncc->TenNhaCungCap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tổng tiền</label>
                        <input type="text" class="form-control" name="tongTien" value="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Phương thức thanh toán</label>
                        <select name="thanhToan" class="form-control input-lg m-bot15">
                            <option value="0">Chuyển khoản</option>
                            <option value="1">Tiền mặt</option>
                            <option value="2">Khác</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info update-btn">Lập phiếu nhập</button>
                </form>


                <form id="phieuNhapCTForm" role="form" action="{{ route('xuLyLapPNCT1') }}" method="POST" >
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Mã phiếu nhập</label>
                        <input type="text" class="form-control" name="maPN" value="{{$maPN}}" readonly>
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

                    <div class="form-group">
                        <label for="">Số lượng</label>
                        <input type="number" class="form-control" name="soLuong" >
                    </div>

                    <div class="form-group">
                        <label for="">Giá sản phẩm</label>
                        <input type="number" class="form-control" name="gia" >
                    </div>

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
                                <th>Giá sản phẩm</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="control" style="display:none; margin:5px;">
                    <a href="{{ route('luuPN', ['id' => $maPN]) }}"><button class="btn btn-info">Lưu</button></a>
                    <a href="{{ route('xoaPN', ['id' => $maPN]) }}"><button class="btn btn-info">Hủy</button></a>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
                                text: 'Lập phiếu nhập thành công',
                                showConfirmButton: false,
                                timer: 800
                            });
                        
                        // Ẩn form phiếu nhập và hiển thị form chi tiết phiếu nhập
                        $('#phieuNhapForm').hide();
                        $('#phieuNhapCTForm').show();
                        $('#control').show();
                    } else {
                        // $('#responseMessage').text('Lập phiếu nhập thất bại: ' + data.message).css('color', 'red');
                        Swal.fire({
                                icon: 'error',
                                title: 'Thất bại',
                                text: 'Lập phiếu nhập thất bại: ' + data.message,
                                showConfirmButton: true
                            });
                    }
                },
                error: function(xhr, status, error) {
                    // console.error('Error:', error);
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
            e.preventDefault(); 

            var formData = $(this).serialize();  

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
                        var kt = false;

                        $('#phieuNhapTable tbody tr').each(function() {
                            var row = $(this);
                            var maSP = row.find('td:nth-child(2)').text();
                            if (maSP === data.maSP) {
                                row.find('td:nth-child(4)').text(data.soLuong);
                                row.find('td:nth-child(5)').text(data.gia);
                                row.find('td:nth-child(6)').text(data.soLuong * data.gia);
                                kt = true;
                                return false;  
                            }
                        });

                        if (!kt) {
                            var newRow = `
                                <tr>
                                    <td>${data.maPN}</td>
                                    <td class="cot-an">${data.maSP}</td>
                                    <td>${data.tenSP}</td>
                                    <td>${data.soLuong}</td>
                                    <td>${data.gia}</td>
                                    <td>${data.soLuong * data.gia}</td>
                                </tr>
                            `;
                            $('#phieuNhapTable tbody').append(newRow);
                        }
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
        $('#phieuNhapCTForm').hide();

        //Tim kiem bang select2
        var selectedValues = {!! json_encode(old('MaSanPham')) !!};
        var selectedLoaiSP = $('#loaiSP').val();

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