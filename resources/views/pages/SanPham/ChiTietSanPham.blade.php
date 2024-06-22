@extends('layout')
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
<div class="col-sm-9 padding-right">
    <div class="col-sm-12 padding-right">
        <div class="product-details">
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{ asset('upload/SanPham/'.$chiTietSanPham->HinhAnh) }}" alt="" />
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information">
                    <img src="{{ asset('frontend/images/product-details/new.jpg') }}" class="newarrival" alt="" />
                    <h2>{{ $chiTietSanPham->TenSanPham }}</h2>
                    <form>
                        <input type="hidden" value="{{$chiTietSanPham->MaSanPham}}" class="cart_product_id_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->TenSanPham}}" class="cart_product_name_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->HinhAnh}}" class="cart_product_image_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->GiaSanPham}}" class="cart_product_price_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->ChieuCao}}" class="cart_product_height_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->ChieuNgang}}" class="cart_product_width_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->ChieuDay}}" class="cart_product_thick_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->CanNang}}" class="cart_product_weight_{{$chiTietSanPham->MaSanPham}}">
                        <input type="hidden" value="{{$chiTietSanPham->ThoiGianBaoHanh }}" class="cart_product_guarantee_{{$chiTietSanPham->MaSanPham}}">
                        <span>
                            <span>{{number_format($chiTietSanPham->GiaSanPham,0,',','.').' đ'}}</span>
                            <label>Số lượng:</label>
                            <input name="qty" type="number" max="{{$chiTietSanPham->SoLuongHienTai}}" min="1"class="cart_product_qty_{{$chiTietSanPham->MaSanPham}}" value="1"/>
                            <input name="productid_hidden" type="hidden"  value="{{$chiTietSanPham->MaSanPham}}" />
                        </span>
                        <input type="button" value="Thêm giỏ hàng" class="btn btn-primary cart btn-sm add-to-cart ThemGioHang" 
                        data-id_product="{{$chiTietSanPham->MaSanPham}}">
                    </form>
                    <p><b>Còn hàng:</b> Tại cửa hàng</p>
                    <p><b>Thời hạn bảo hành:</b> {{ $chiTietSanPham->ThoiGianBaoHanh }} tháng</p>
                    <p><b>Thương hiệu:</b> {{ $chiTietSanPham->ThuongHieu->TenThuongHieu }}</p>
                    <p><b>Danh mục:</b> {{ $chiTietSanPham->DanhMuc->TenDanhMuc }}</p>
                </div>
            </div>
        </div>
        
        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active" ><a href="#details" data-toggle="tab">Thông tin sản phẩm</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Sản phẩm liên quan</a></li>
                    <li><a href="#tag" data-toggle="tab">Thông số kỹ thuật</a></li>
                    <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="details" >
                    <div class="col-sm-12">
                        <span class="container">
                            {!! $chiTietSanPham->MoTa !!}
                        </span>
                    </div>
                </div>
                <div class="tab-pane fade" id="companyprofile" >
                    @foreach ($sanPhamLienQuan as $key => $valueSanPham)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <form>
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $valueSanPham->MaSanPham }}" class="cart_product_id_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->TenSanPham }}" class="cart_product_name_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->HinhAnh }}" class="cart_product_image_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->GiaSanPham }}" class="cart_product_price_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->ChieuCao }}" class="cart_product_height_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->ChieuNgang }}" class="cart_product_width_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->ChieuDay }}" class="cart_product_thick_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->CanNang }}" class="cart_product_weight_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="{{ $valueSanPham->ThoiGianBaoHanh }}" class="cart_product_guarantee_{{ $valueSanPham->MaSanPham }}">
                                        <input type="hidden" value="1" class="cart_product_qty_{{ $valueSanPham->MaSanPham }}">
                                        <a href="{{ route('/ChiTietSanPham', $valueSanPham->MaSanPham) }}">
                                            <img src="{{ asset('upload/SanPham/'.$valueSanPham->HinhAnh) }}" alt="" />
                                            <p class="product-name">{{ $valueSanPham->TenSanPham }}</p>
                                            <h2 class="">{{  number_format($valueSanPham->GiaSanPham,0,',','.').'₫'  }}</h2>
                                            <p class="vote-txt">
                                                @php
                                                $count = 0;
                                                $tongSoSao = 0;
                                                    foreach($allDanhGia as $key => $danhGia){
                                                        if($danhGia->MaSanPham == $valueSanPham->MaSanPham){
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
                                        data-id_product="{{ $valueSanPham->MaSanPham }}">
                                            <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="tag" >
                    <div class="col-sm-12">
                        <p class="specifications_title">
                            Thông số kỹ thuật của sản phẩm {{ $chiTietSanPham->TenSanPham }}
                        </p>
                        <div class="specifications_table">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 50%">Danh mục thông số kỹ thuật</th>
                                        <th style="width: 50%">Thông số kỹ thuật</th>
                                    </tr>
                                    @foreach ($allSanPhamTSKT as $key => $sanPhamTSKT)
                                    <tr>
                                        <td>{{ $sanPhamTSKT->ThongSoKyThuat->DanhMucTSKT->TenDMTSKT }}</td>
                                        <td>{{ $sanPhamTSKT->ThongSoKyThuat->TenTSKT ?? 'none' }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>Hãng</td>
                                        <td>{{ $chiTietSanPham->ThuongHieu->TenThuongHieu }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kích thước</td>
                                        <td>
                                            Ngang {{ $chiTietSanPham->ChieuNgang }} cm - Cao {{ $chiTietSanPham->ChieuCao }} cm - Dày {{ $chiTietSanPham->ChieuDay }} cm - Cân nặng {{ $chiTietSanPham->CanNang }} kg 
                                        </td>
                                    </tr>
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" >
                    <div class="col-sm-12">
                        <ul>
                            @if (Session('user'))
                                @php
                                    $user = Session::get('user');
                                @endphp            
                                <li><a style="text-transform: none" href=""><i class="fa fa-user"></i>{{ $user['TenTaiKhoan'] }}</a></li>
                            @else
                                <li><a style="text-transform: none" href=""><i class="fa fa-user"></i>Tên tài khoản</a></li>
                            @endif
                        </ul>
                        <p><b>Viết đánh giá của bạn</b></p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                            </div>
                        @elseif (session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                            </div>
                        @endif
                        <form>
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $chiTietSanPham->MaSanPham }}" class="MaSanPham_{{ $chiTietSanPham->MaSanPham }}" name="MaSanPham">
                            <textarea placeholder="Viết đánh giá của bạn ở đây" class="NoiDung_{{ $chiTietSanPham->MaSanPham }}" name="NoiDung"></textarea>
                            <div class='rating-stars'>
                                <ul id='stars' class="list-inline">
                                  <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                  </li>
                                  <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                  </li>
                                  <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                  </li>
                                  <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                  </li>
                                  <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                  </li>
                                </ul>
                            </div>
                            <button type="submit" name="ThemDanhGia" class="btn btn-default pull-right ThemDanhGia"
                            data-MaSanPham="{{ $chiTietSanPham->MaSanPham }}" >
                                Đánh giá
                            </button>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="response-area">
                            <h2>Đánh giá của khách hàng về sản phẩm</h2>
                            <ul class="media-list">
                            @foreach ($allDanhGia as $key => $danhGia)
                                @foreach ($allTaiKhoan as $key => $taiKhoan)
                                    @if ($taiKhoan->Email == $danhGia->Email && $danhGia->MaSanPham == $chiTietSanPham->MaSanPham)
                                    <li class="media col-sm-12">
                                        <a class="pull-left" href="#">
                                            <img class="media-object" src="{{ asset('upload/TaiKhoan/'.$taiKhoan->HinhAnh) }}" alt="Ảnh đại diện">
                                        </a>
                                        <div class="media-body">
                                            <ul class="sinlge-post-meta">
                                                <li><i class="fa fa-user"></i>{{ $taiKhoan->TenTaiKhoan }}</li>
                                                <li><i class="fa fa-clock-o"></i><td>{{  date("s:i:H", strtotime($danhGia->ThoiGianTao)) }}</td></li>
                                                <li><i class="fa fa-calendar"></i><td>{{  date("d M Y", strtotime($danhGia->ThoiGianTao)) }}</td></li>
                                            </ul>
                                            <p>{{ $danhGia->NoiDung }}</p>
                                            <ul class="list-inline rating" title="Average Rating">
                                                <li class="rate-this">Đánh giá dựa trên số sao:</li>
                                                @for ($count=1; $count<=5; $count++)
                                                    @php
                                                        $color = '';
                                                        if($count<=$danhGia->SoSao){
                                                            $color = 'color:#ffcc00;';
                                                        }
                                                        else{
                                                            $color = 'color:#ccc;';
                                                        }
                                                    @endphp
                                                    <li style="cursor: pointer; {{ $color }} font-size: 14px"><i class="fa fa-star"></i></li>
                                                @endfor
                                            </ul>
                                        </div>  
                                    </li>
                                    @endif
                                @endforeach
                            @endforeach
                            </ul>					
                        </div><!--/Response-area-->
                    </div>
                </div>
            </div>
        </div><!--/category-tab-->
    </div>
</div>
@endsection
@section('js-custom')
    <script>
        ClassicEditor
        .create(document.querySelector('#MoTa'))
        .catch(error => {
            console.error(error);
        })
    </script>
@endsection
