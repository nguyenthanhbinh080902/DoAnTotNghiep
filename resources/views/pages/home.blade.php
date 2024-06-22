@extends('layout')
@section('header-bottom')
    <div class="col-sm-8">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="mainmenu pull-left">
            <ul class="nav navbar-nav collapse navbar-collapse">
                <li><a href="{{ route('/') }}" class="active">Home</a></li>
                <li><a href="{{ route('/HienThiBaiViet') }}" class="active">Bài viết</a></li>
                <li><a href="{{ route('/') }}" class="active">Liên hệ</a></li>
            </ul>
        </div>
    </div>
    <div class="col-sm-4">
        <form action="{{ route('/TimKiem') }}" method="GET">
            {{ csrf_field() }}
            <div class="search_box pull-right">
                <input type="text" name="keywords_submit" placeholder="Tìm kiếm"/>
                <input style="width: 50px" type="submit" name="search_items" class="btn btn-success btn-sm" value="Tìm">
            </div>
        </form>
    </div>
@endsection
@section('slider')
<div class="col-sm-12">
    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#slider-carousel" data-slide-to="1"></li>
            <li data-target="#slider-carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <div class="col-sm-6">
                    <h1><span>E</span>lectronic Shop</h1>
                    <h2>Nơi bán sản phẩm điện tử số 1 Việt Nam</h2>
                    <p>Luôn phục vụ tận tình quý khách mọi lúc mọi nơi</p>
                    <button type="button" class="btn btn-default get">Get it now</button>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('upload/SanPham/smart-tivi-toshiba-43-inch-43v31mp6383429964306985283.jpg') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
                </div>
            </div>
            <div class="item">
                <div class="col-sm-6">
                    <h1><span>E</span>lectronic Shop</h1>
                    <h2>Nơi bán sản phẩm điện tử số 1 Việt Nam</h2>
                    <p>Luôn phục vụ tận tình quý khách mọi lúc mọi nơi</p>
                    <button type="button" class="btn btn-default get">Get it now</button>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('upload/SanPham/android-sony-4k-55-inch-kd-55x80k-180322-022717-550x34097.png') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
                </div>
            </div>
            <div class="item">
                <div class="col-sm-6">
                    <h1><span>E</span>lectronic Shop</h1>
                    <h2>Nơi bán sản phẩm điện tử số 1 Việt Nam</h2>
                    <p>Luôn phục vụ tận tình quý khách mọi lúc mọi nơi</p>
                    <button type="button" class="btn btn-default get">Get it now</button>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('upload/SanPham/camera-ip-360-do-3mp-tiandy-tc-h332n-thumb-2-600x60037.jpg') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
                </div>
            </div>
        </div>
        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
@endsection
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh mục sản phẩm</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach ($allDanhMuc as $key => $danhMuc)
            @if ($danhMuc->DanhMucCha == 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#{{ $danhMuc->MaDanhMuc }}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        </a>
                        <a href="{{ route('/HienThiDanhMucCha', $danhMuc->MaDanhMuc) }}">{{ $danhMuc->TenDanhMuc }}</a>                        </h4>
                    </div>
                    <div id="{{ $danhMuc->MaDanhMuc }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach ($allDanhMuc as $key => $valueDanhMuc)
                                @if($valueDanhMuc->DanhMucCha == $danhMuc->MaDanhMuc)
                                    <li><a href="{{ route('/HienThiDanhMucCon', $valueDanhMuc->MaDanhMuc) }}">{{ $valueDanhMuc->TenDanhMuc }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        </div><!--/category-products-->
    </div>
</div>

{{--chuong trinh giam gia--}}
@if(!$allCTGG->isEmpty())
    <div class="col-sm-9 padding-right">
    <div class="recommended_items">
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($allCTGG as $valueSanpham)
                    <img src="{{ asset($valueSanpham->HinhAnh) }}" class="discount-image" alt="{{ $valueSanpham->TenCTGG }}">
                    <div class="item {{ $loop->first ? 'active' : '' }}">
                        <div class="products-container">
                        @foreach ($valueSanpham->chuongTrinhGiamGiaSPs as $index => $sanPhamGG)
                            @php
                                $sanPham = $sanPhamGG -> SanPham;
                             @endphp
                            <div class="col-sm-3 product-item {{ $index >= 4 ? 'hidden' : '' }}">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <form>
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $sanPham->MaSanPham }}" class="cart_product_id_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->TenSanPham }}" class="cart_product_name_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->HinhAnh }}" class="cart_product_image_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->GiaSanPham }}" class="cart_product_price_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->ChieuCao }}" class="cart_product_height_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->ChieuNgang }}" class="cart_product_width_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->ChieuDay }}" class="cart_product_thick_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->CanNang }}" class="cart_product_weight_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->ThoiGianBaoHanh }}" class="cart_product_guarantee_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="{{ $sanPham->SoLuongHienTai }}" class="cart_product_quantity_{{ $sanPham->MaSanPham }}">
                                                <input type="hidden" value="1" class="cart_product_qty_{{ $sanPham->MaSanPham }}">
                                                <a href="{{ route('/ChiTietSanPham', $sanPham->MaSanPham) }}">
                                                    <img src="{{ asset('upload/SanPham/'.$sanPham->HinhAnh) }}" alt="" />
                                                    <p class="product-name">{{ $sanPham->TenSanPham }}</p>
                                                    <h2 class="">{{  number_format($sanPham->GiaSanPham,0,',','.').'₫'  }}</h2>
                                                    <p class="vote-txt">
                                                        @php
                                                        $count = 0;
                                                        $tongSoSao = 0;
                                                            foreach($allDanhGia as $key => $danhGia){
                                                                if($danhGia->MaSanPham == $sanPham->MaSanPham){
                                                                    $count++;
                                                                    $tongSoSao += $danhGia->SoSao;
                                                                }
                                                            }
                                                        @endphp
                                                        @php
                                                            if($count > 0){
                                                            $tongSoSao = $tongSoSao/$count
                                                        @endphp
                                                            <b>{{ number_format($tongSoSao, 1) }}</b>
                                                            <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                            <b>({{ $count }})</b>
                                                        @php
                                                            }elseif($count == 0){
                                                        @endphp
                                                            <b>0</b>
                                                            <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                            <b>(0)</b>
                                                        @php
                                                            }
                                                        @endphp
                                                    </p>
                                                </a>
                                                <button type="button" class="btn btn-default add-to-cart ThemGioHang"
                                                data-id_product="{{ $sanPham->MaSanPham }}">
                                                    <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="left recommended-item-control" onclick="slideProducts('prev')" href="javascript:void(0)" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" onclick="slideProducts('next')" href="javascript:void(0)" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
</div>
@else
<div class="col-sm-9">
    <div class="recommended_items">
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <img src="{{ asset('frontend/im') }}" style="margin-bottom: 15px; width: 100%" alt="">    
            <div class="carousel-inner">
                @foreach ($sanPhamNoiBat->chunk(4) as $valueSanPham)
                    <div class="item {{ $loop->first ? 'active' : '' }}">	
                    @foreach ($valueSanPham as $sanPham)
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <form>
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $sanPham->MaSanPham }}" class="cart_product_id_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->TenSanPham }}" class="cart_product_name_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->HinhAnh }}" class="cart_product_image_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->GiaSanPham }}" class="cart_product_price_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->ChieuCao }}" class="cart_product_height_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->ChieuNgang }}" class="cart_product_width_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->ChieuDay }}" class="cart_product_thick_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->CanNang }}" class="cart_product_weight_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->ThoiGianBaoHanh }}" class="cart_product_guarantee_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="{{ $sanPham->SoLuongHienTai }}" class="cart_product_quantity_{{ $sanPham->MaSanPham }}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{ $sanPham->MaSanPham }}">
                                            <a href="{{ route('/ChiTietSanPham', $sanPham->MaSanPham) }}">
                                                <img src="{{ asset('upload/SanPham/'.$sanPham->HinhAnh) }}" alt="" />
                                                <p class="product-name">{{ $sanPham->TenSanPham }}</p>
                                                <h2 class="">{{  number_format($sanPham->GiaSanPham,0,',','.').'₫'  }}</h2>
                                                <p class="vote-txt">
                                                    @php
                                                    $count = 0;
                                                    $tongSoSao = 0;
                                                        foreach($allDanhGia as $key => $danhGia){
                                                            if($danhGia->MaSanPham == $sanPham->MaSanPham){
                                                                $count++;
                                                                $tongSoSao += $danhGia->SoSao;
                                                            }
                                                        }
                                                    @endphp
                                                    @php
                                                        if($count > 0){
                                                        $tongSoSao = $tongSoSao/$count
                                                    @endphp
                                                        <b>{{ number_format($tongSoSao, 1) }}</b>
                                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                        <b>({{ $count }})</b>
                                                    @php
                                                        }elseif($count == 0){
                                                    @endphp
                                                        <b>0</b>
                                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                                        <b>(0)</b>
                                                    @php
                                                        }
                                                    @endphp
                                                </p>
                                            </a>
                                            <button type="button" class="btn btn-default add-to-cart ThemGioHang"
                                            data-id_product="{{ $sanPham->MaSanPham }}">
                                                <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                            </button>
                                        </form>
                                    </div>             
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endforeach
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>			
        </div>
    </div>
</div>
@endif

<div class="category-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @php
                $i = 0;
            @endphp
            @foreach ($allDanhMuc as $key => $danhMuc)
                @if ($danhMuc->DanhMucCha == 0)
                    @php
                        $i++;
                    @endphp
                    <li class="tabs_pro {{ $i==1 ? 'active' : ''}}" data-id="{{ $danhMuc->MaDanhMuc }}"><a href="#tshirt" data-toggle="tab">{{ $danhMuc->TenDanhMuc }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
    <div id="tabs_product"></div>
</div><!--/category-tab-->
<div class="col-sm-12">
    <div class="features_items">
        <h2 class="title text-center">Sản phẩm nổi bật</h2>
        @foreach ($allSanPham as $key => $sanPham)
        <div class="col-sm-15">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $sanPham->MaSanPham }}" class="cart_product_id_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->TenSanPham }}" class="cart_product_name_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->HinhAnh }}" class="cart_product_image_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->GiaSanPham }}" class="cart_product_price_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->ChieuCao }}" class="cart_product_height_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->ChieuNgang }}" class="cart_product_width_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->ChieuDay }}" class="cart_product_thick_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->CanNang }}" class="cart_product_weight_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->ThoiGianBaoHanh }}" class="cart_product_guarantee_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="{{ $sanPham->SoLuongHienTai }}" class="cart_product_quantity_{{ $sanPham->MaSanPham }}">
                            <input type="hidden" value="1" class="cart_product_qty_{{ $sanPham->MaSanPham }}">
                            <a href="{{ route('/ChiTietSanPham', $sanPham->MaSanPham) }}">
                                <img src="{{ asset('upload/SanPham/'.$sanPham->HinhAnh) }}" alt="" />
                                <p class="product-name">{{ $sanPham->TenSanPham }}</p>
                                <h2 class="">{{  number_format($sanPham->GiaSanPham,0,',','.').'₫'  }}</h2>
                                <p class="vote-txt">
                                    @php
                                    $count = 0;
                                    $tongSoSao = 0;
                                        foreach($allDanhGia as $key => $danhGia){
                                            if($danhGia->MaSanPham == $sanPham->MaSanPham){
                                                $count++;
                                                $tongSoSao += $danhGia->SoSao;
                                            }
                                        }
                                    @endphp
                                    @php
                                        if($count > 0){
                                        $tongSoSao = $tongSoSao/$count
                                    @endphp
                                        <b>{{ number_format($tongSoSao, 1) }}</b>
                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                        <b>({{ $count }})</b>
                                    @php
                                        }elseif($count == 0){
                                    @endphp
                                        <b>0</b>
                                        <i style="color:#FFCC36; margin-right: 5px" class="fa fa-star fa-fw"></i>
                                        <b>(0)</b>
                                    @php
                                        }
                                    @endphp
                                </p>
                            </a>
                            <button type="button" class="btn btn-default add-to-cart ThemGioHang"
                            data-id_product="{{ $sanPham->MaSanPham }}">
                                <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $allSanPham->links('vendor.pagination.custom') }}
</div>
<div class="col-sm-12 padding-right">
    <div class="shopping-trends">
        <strong class="name-box">Xu hướng mua sắm</strong>
        <ul>
            <li>
                <a href="{{ route('/HienThiDanhMucCha', [17]) }}">
                    <img src="{{ asset('backend/images/xuhuongmuasam1.png') }}" alt="">
                    <span>Máy lạnh</span>
                    <strong>Giá từ 4.999.000 đ</strong>
                </a>
            </li>
            <li>
                <a href="{{ route('/HienThiDanhMucCha', [1]) }}">
                    <img src="{{ asset('backend/images/xuhuongmuasam2.png') }}" alt="">
                    <span>Máy lạnh</span>
                    <strong>Giá từ 4.999.000 đ</strong>
                </a>
            </li>
            <li>
                <a href="{{ route('/HienThiDanhMucCha', [1]) }}">
                    <img src="{{ asset('backend/images/xuhuongmuasam3.png') }}" alt="">
                    <span>Máy lạnh</span>
                    <strong>Giá từ 4.999.000 đ</strong>
                </a>
            </li>
            <li>
                <a href="{{ route('/HienThiDanhMucCha', [1]) }}">
                    <img src="{{ asset('backend/images/xuhuongmuasam4.png') }}" alt="">
                    <span>Máy lạnh</span>
                    <strong>Giá từ 4.999.000 đ</strong>
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function showAllProducts(button) {
            const container = $(button).closest('.item').find('.products-container');
            const hiddenItems = container.find('.product-item.hidden');
            if (hiddenItems.length) {
                hiddenItems.removeClass('hidden');
                $(button).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
            } else {
                container.find('.product-item').each(function (index) {
                    if (index >= 4) {
                        $(this).addClass('hidden');
                    }
                });
                $(button).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            }
        }

        window.showAllProducts = showAllProducts; // Expose the function to the global scope

        function slideProducts(direction) {
            $('.item.active').each(function () {
                const container = $(this).find('.products-container');
                const items = container.find('.product-item');
                const visibleItems = container.find('.product-item:visible');
                let startIndex = items.index(visibleItems.first());

                if (direction === 'prev') {
                    startIndex = Math.max(startIndex - 4, 0);
                } else if (direction === 'next') {
                    startIndex = Math.min(startIndex + 4, items.length - 4);
                }

                items.addClass('hidden').slice(startIndex, startIndex + 4).removeClass('hidden');
            });
        }

        window.slideProducts = slideProducts; // Expose the function to the global scope
    });
</script>
<style>
    .discount-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
    }

    .discount-image {
        margin-bottom: 15px;
        margin-top: 2%;
        width: 100%;
        height: auto;
        max-height: 200px;
    }

    /*.products-container {*/
    /*    display: flex;*/
    /*    flex-wrap: wrap;*/
    /*}*/

    .product-item.hidden {
        display: none;
    }

    .recommended-item-control {
        cursor: pointer;
    }
</style>
@endsection

