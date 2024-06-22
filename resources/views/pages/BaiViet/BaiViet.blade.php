@extends('layout')
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
                    <img src="{{ asset('frontend/images/home/vi-vn-may-giat-samsung-inverter-8kg-ww80t3020ww-sv-0139.jpg') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
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
                    <img src="{{ asset('frontend/images/home/camera-ip-360-do-3mp-tiandy-tc-h332n-thumb-2-600x60070.jpg') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
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
                    <img src="{{ asset('frontend/images/home/tai-nghe-bluetooth-airpods-pro-2-magsafe-charge-apple-mqd83-trang-090922-034128-600x600198.jpg') }}" style="height: 400px; width: 315px" class="girl img-responsive" alt="" />
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
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="left-sidebar">
                <div class="brands_products"><!--brands_products-->
                    <h2>Danh mục bài viết</h2>
                    <div class="brands-name">
                        <ul class="nav nav-pills nav-stacked">
                            @foreach ($allDanhMucBV as $key => $danhMucBV)
                            <li><a href="{{ route('/HienThiBaiVietTheoDMBV', $danhMucBV->MaDanhMucBV) }}"><span class="pull-right"></span>{{ $danhMucBV->TenDanhMucBV }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 padding-right">
            <div class="blog-post-area">
                <h2 class="title text-center">Bài viết mới nhất</h2>
                @foreach ($allBaiViet as $key => $baiViet)
                <div class="single-blog-post col-sm-6" style="float: left">
                    <a href="{{ route('/ChiTietBaiViet', $baiViet->MaBaiViet) }}">
                        <h3>{{ $baiViet->TenBaiViet }}</h3>
                            <img src="{{ asset('upload/BaiViet/'.$baiViet->HinhAnh) }}" alt="Hình ảnh bài viết">
                        <a  class="btn btn-primary" href="{{ route('/ChiTietBaiViet', $baiViet->MaBaiViet) }}">Xem chi tiết</a>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="pagination-area" style="width: 200px; margin:0 auto;">
            <ul class="pagination">
                <li><a href=""><i class="fa fa-angle-double-left"></i></a></li>
                <li><a href="" class="active">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>
@endsection