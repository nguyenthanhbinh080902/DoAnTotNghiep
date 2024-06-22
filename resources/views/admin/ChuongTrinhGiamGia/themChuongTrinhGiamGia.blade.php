@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm chương trình giảm giá
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form  action="{{ route('/taoChuongTrinhGiamGia') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="TenCTGG">Tên chương trình giảm giá:</label>
                                <input type="text" class="form-control @error('TenCTGG') is-invalid @enderror"
                                       onkeyup="ChangeToSlug();" id="slug" name="TenCTGG" value="{{ old('TenCTGG') }}">
                            </div>
                            @error('TenCTGG')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="SlugCTGG">Slug:</label>
                                <input id="convert_slug" type="text"
                                       class="form-control @error('SlugCTGG') is-invalid @enderror" name="SlugCTGG"
                                       value="{{ old('SlugCTGG') }}">
                            </div>
                            @error('SlugCTGG')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="HinhAnh">Hình ảnh:</label>
                                <input type="file" class="form-control @error('HinhAnh') is-invalid @enderror"
                                       name="HinhAnh" placeholder="Hình ảnh">
                            </div>
                            @error('HinhAnh')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="MoTa">Mô tả:</label>
                                <textarea id="MoTa" style="resize: none" rows="10"
                                          class="form-control @error('MoTa') is-invalid @enderror" name="MoTa"
                                          placeholder="Mô tả">{{ old('MoTa') }}</textarea>
                            </div>
                            @error('MoTa')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thời gian có hiệu lực</label>
                                <input type="datetime-local"
                                       class="form-control @error('ThoiGianBatDau') is-invalid @enderror"
                                       name="ThoiGianBatDau" value="{{ old('ThoiGianBatDau') }}">
                            </div>
                            @error('ThoiGianBatDau')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thời gian hết hiệu lực</label>
                                <input type="datetime-local"
                                       class="form-control @error('ThoiGianKetThuc') is-invalid @enderror"
                                       name="ThoiGianKetThuc" value="{{ old('ThoiGianKetThuc') }}">
                            </div>
                            @error('ThoiGianKetThuc')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="DanhMuc">Loại sản phẩm:</label>
                                        <select class="form-control" id="DanhMuc" name="DanhMuc">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->MaDanhMuc }}">{{ $category->TenDanhMuc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="SanPham">Sản phẩm:</label>
                                        <select class="form-control select2" id="SanPham" name="SanPham">
                                            <!-- Options sẽ được load qua AJAX -->
                                        </select>
                                    </div>
                                    @error('SanPham')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="PhanTramGiam">Số phần trăm giảm giá:</label>
                                <input type="text" class="form-control @error('PhanTramGiam') is-invalid @enderror"
                                       id="PhanTramGiam" name="PhanTramGiam" value="{{ old('PhanTramGiam') }}">
                            </div>
                            @error('PhanTramGiam')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <button type="button" class="btn btn-info" id="add-product-btn">Thêm sản phẩm</button>

                            <h3>Sản Phẩm Đã Chọn</h3>
                            <table class="table table-bordered" id="selected-products-table">
                                <thead>
                                <tr>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Phần trăm giảm</th>
                                    <th>Hành Động</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Dòng sẽ được thêm động ở đây -->
                                </tbody>
                            </table>

                            <input type="hidden" name="selectedProducts" id="selectedProducts" value="{{ old('selectedProducts', session('selectedProducts')) }}">

                            <button type="submit" class="btn btn-info">Thêm chương trình giảm giá</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Tải các tệp thư viện -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#DanhMuc').change(function() {
                var categoryId = $(this).val();
                // console.log('Danh Muc changed:', categoryId);  // Log this to verify event is triggered
                if (categoryId) {
                    $.ajax({
                        url: '/api/san-pham/' + categoryId,
                        method: 'GET',
                        success: function(data) {
                            $('#SanPham').empty();
                            $.each(data, function(key, value) {
                                $('#SanPham').append('<option value="'+ value.id +'" data-price="'+ value.GiaSanPham +'">'+ value.TenSanPham +'</option>');
                            });
                        },
                        // error: function(xhr, status, error) {
                        //     console.error('Error:', error);
                        // }
                    });
                } else {
                    $('#SanPham').empty();
                }
            });

            $('#add-product-btn').click(function() {
                var selectedProduct = $('#SanPham').select2('data')[0];
                if (selectedProduct) {
                    var productId = selectedProduct.id;
                    var isProductExists = false;

                    // Kiểm tra nếu sản phẩm đã tồn tại trong bảng
                    $('#selected-products-table tbody tr').each(function() {
                        if ($(this).data('id') == productId) {
                            isProductExists = true;
                            return false;  // Thoát khỏi vòng lặp each
                        }
                    });

                    if (!isProductExists) {
                        var phanTramGiam = $('#PhanTramGiam').val();
                        var row = `
                <tr data-id="${selectedProduct.id}">
                    <td>${selectedProduct.text}</td>
                    <td>${$(selectedProduct.element).data('price')}</td>
                    <td>${phanTramGiam}</td>
                    <td><button type="button" class="btn btn-danger remove-product-btn">Xóa</button></td>
                </tr>
                `;
                        $('#selected-products-table tbody').append(row);
                        $('#SanPham').val(null).trigger('change');

                        updateSelectedProductsInput();
                    } else {
                        alert('Sản phẩm đã tồn tại trong bảng.');
                    }
                }
            });


            $(document).on('click', '.remove-product-btn', function() {
                $(this).closest('tr').remove();
                updateSelectedProductsInput();
            });

            function updateSelectedProductsInput() {
                var selectedProducts = [];
                $('#selected-products-table tbody tr').each(function() {
                    var id = $(this).data('id');
                    var phanTramGiam = $(this).find('td').eq(2).text();
                    selectedProducts.push({ id: id, phanTramGiam: phanTramGiam });
                });
                $('#selectedProducts').val(JSON.stringify(selectedProducts));
                console.log(JSON.stringify(selectedProducts))
            }

            // Hiển thị lại sản phẩm đã chọn khi load trang
            var selectedProductsFromSession =  @json(session('selectedProducts', []));
            try {
                selectedProductsFromSession = JSON.parse(selectedProductsFromSession);
            } catch (e) {
                selectedProductsFromSession = [];
            }
            console.log(selectedProductsFromSession);
            if (selectedProductsFromSession.length > 0) {
                var productIds = selectedProductsFromSession.map(function(product) { return product.id; });
                $.ajax({
                    url: '/api/san-pham/chi-tiet',
                    method: 'POST',
                    data: { ids: productIds },
                    success: function(data) {
                        selectedProductsFromSession.forEach(function(product) {
                            var productDetail = data.find(function(detail) { return detail.id == product.id; });
                            if (productDetail) {
                                var row = `
                        <tr data-id="${product.id}">
                            <td>${productDetail.TenSanPham}</td>
                            <td>${productDetail.GiaSanPham}</td>
                            <td>${product.phanTramGiam}</td>
                            <td><button type="button" class="btn btn-danger remove-product-btn">Xóa</button></td>
                        </tr>
                        `;
                                $('#selected-products-table tbody').append(row);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    </script>
@endsection

@section('js-custom')
    <script>
        ClassicEditor.create(document.querySelector('#MoTa')).catch(error => {
            console.error(error);
        });
    </script>
@endsection
