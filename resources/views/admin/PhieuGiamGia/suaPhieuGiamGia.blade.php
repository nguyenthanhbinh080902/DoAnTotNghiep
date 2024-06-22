@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật mã giảm giá sản phẩm
                </header>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        @foreach ($suaPhieu as $key => $edit_value)
                            <form role="form" action="{{ Route('/suaPhieuGG', [$edit_value->MaGiamGia]) }}"
                                  method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên phiếu giảm giá</label>
                                    <input type="text" value="{{ old('TenMaGiamGia', $edit_value->TenMaGiamGia) }}"
                                           class="@error('TenMaGiamGia') is-invalid @enderror form-control"
                                           name="TenMaGiamGia" placeholder="Tên mã giảm giá">
                                </div>
                                @error('TenMaGiamGia')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã code phiếu giảm giá</label>
                                    <input type="text" value="{{ old('MaCode', $edit_value->MaCode) }}"
                                           class="@error('MaCode') is-invalid @enderror form-control"
                                           name="MaCode" placeholder="Code mã giảm giá">
                                </div>
                                @error('MaCode')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Slug giảm giá</label>
                                    <input type="text" value="{{ old('SlugMaGiamGia', $edit_value->SlugMaGiamGia) }}"
                                           class="@error('SlugMaGiamGia') is-invalid @enderror form-control"
                                           name="SlugMaGiamGia" placeholder="Code mã giảm giá">
                                </div>
                                @error('SlugMaGiamGia')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thời gian có hiệu lực</label>
                                    <input type="datetime-local" class="form-control @error('ThoiGianBatDau') is-invalid @enderror"
                                           name="ThoiGianBatDau" value="{{old('ThoiGianBatDau', $edit_value->ThoiGianBatDau)}}">
                                </div>
                                @error('ThoiGianBatDau')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thời gian hết hiệu lực</label>
                                    <input type="datetime-local" class="form-control @error('ThoiGianKetThuc') is-invalid @enderror"
                                           name="ThoiGianKetThuc" value="{{old('ThoiGianKetThuc', $edit_value->ThoiGianKetThuc)}}">
                                </div>
                                @error('ThoiGianKetThuc')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Cấp bậc thành viên</label>
                                    <select name="BacNguoiDung" id="BacNguoiDung" class="form-control input-lg m-bot15">
                                        @if ($edit_value->BacNguoiDung == '1')
                                            <option value="1" >Vàng</option>
                                            <option value="2" >Kim Cương</option>
                                            <option value="3" >Bạch Kim</option>
                                        @elseif($edit_value->BacNguoiDung == '2')
                                            <option value="1" >Vàng</option>
                                            <option value="2" >Kim Cương</option>
                                            <option value="3" >Bạch Kim</option>
                                        @else
                                            <option value="1" >Vàng</option>
                                            <option value="2" >Kim Cương</option>
                                            <option value="3" >Bạch Kim</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số tiền | Phần trămm giảm</label>
                                    <select name="DonViTinh" id="DonViTinh" class="form-control input-lg m-bot15">
                                        @if ($edit_value->DonViTinh == '1')
                                            <option value="1" selected>Giảm theo tiền</option>
                                            <option value="2">Giảm theo %</option>
                                        @else
                                            <option value="1">Giảm theo tiền</option>
                                            <option value="2" selected>Giảm theo %</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trị giá</label>
                                    <input type="text" value="{{ old('TriGia', $edit_value->TriGia) }}"
                                           class="@error('TriGia') is-invalid @enderror form-control"
                                          id="TriGia" name="TriGia" placeholder="Giá trị">
                                </div>
                                @error('TriGia')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" name="suaPhieuGG" class="btn btn-info">Cập nhật mã giảm giá
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var selectElement = document.getElementById('DonViTinh');
            var triGiaInput = document.getElementById('TriGia');
            var initialTriGiaValue = triGiaInput.value; // Lưu giá trị ban đầu của TriGia

            function updateTriGiaMaxLength(clearValue = true) {
                if (clearValue) {
                    triGiaInput.value = ''; // Xóa giá trị hiện tại của trường TriGia khi thay đổi lựa chọn
                }

                if (selectElement.value === '2') { // Giảm theo %
                    triGiaInput.maxLength = 3;
                    triGiaInput.removeEventListener('input', handleMoneyInput);
                    triGiaInput.addEventListener('input', handlePercentageInput);
                } else {
                    triGiaInput.removeAttribute('maxLength');
                    triGiaInput.addEventListener('input', handleMoneyInput);
                    triGiaInput.removeEventListener('input', handlePercentageInput);
                }
            }

            function handlePercentageInput() {
                var value = parseInt(triGiaInput.value.replace(/,/g, ''), 10);
                if (isNaN(value)) {
                    triGiaInput.value = '';
                } else if (value < 1) {
                    triGiaInput.value = 1;
                } else if (value > 100) {
                    triGiaInput.value = 100;
                } else {
                    triGiaInput.value = value.toString();
                }
            }

            function handleMoneyInput() {
                var value = triGiaInput.value.replace(/,/g, '');
                if (value.startsWith('0') && value.length > 1) {
                    value = value.replace(/^0+/, '');
                }
                triGiaInput.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Cập nhật độ dài khi giá trị của select box thay đổi và xóa giá trị nhập vào
            selectElement.addEventListener('change', function() {
                updateTriGiaMaxLength(true);
            });

            // Gọi hàm khi trang được tải để thiết lập độ dài ban đầu mà không xóa giá trị nhập vào
            updateTriGiaMaxLength(false);

            const amountInput = document.getElementById('TriGia');
            amountInput.addEventListener('input', function(e) {
                let value = e.target.value;
                // Chỉ cho phép nhập số
                value = value.replace(/[^0-9]/g, '');
                e.target.value = value;
            });

            amountInput.addEventListener('input', function(e) {
                let value = e.target.value;

                // Loại bỏ tất cả dấu phẩy
                value = value.replace(/,/g, '');

                // Thêm dấu phẩy dưới dạng dấu phân cách nghìn
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                e.target.value = value;
            });
        });
    </script>

@endsection
