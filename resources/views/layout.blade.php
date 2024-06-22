<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- SEO --}}
	<meta name="description" content="{{ $meta_desc }}">
	<meta name="keywords" content="{{ $meta_keywords }}">
	<meta name="robots" content="INDEX,FOLLOW">
    <meta name="author" content="{{ $url_canonical }}">
	<title>{{ $meta_title }}</title>
	<link rel="icon" href="{{ asset('frontend/images/home/meta-logo.png') }}" type="image/x-icon">
	<meta property="og:image" content="{{ $image_og }}">
	<meta property="og:site_name" content="http://127.0.0.1:8000">
	<meta property="og:description" content="{{ $meta_desc }}">
	<meta property="og:title" content="{{ $meta_title }}">l
	<meta property="og:url" content="{{ $url_canonical }}">
	<meta property="og:type" content="website">
	{{-- SEO end here --}}
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/profile.css') }}" rel="stylesheet" >
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">
	<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="logo pull-left">
							<a href="{{ route('/') }}"><img src="{{ asset('frontend/images/home/logo.png') }}" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
							</div>
							<div class="btn-group">
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								@php
									$maTaiKhoan = Session::get('MaTaiKhoan');
									if($maTaiKhoan != ''){}
								@endphp
								@if (session('user'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('/thong-tin-tai-khoan') }}"><i class="fa fa-user"></i>{{ htmlspecialchars(session('user')['TenTaiKhoan']) }}</a>
                                    </li>
								@endif
{{--								<li><a href="{{ route('indexDMK')}}"><i class="fa fa-user"></i> Account</a></li>--}}
								<li><a href="{{ route('/ThanhToan') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								@if (session('user'))
									@php
										$user = session('user');
										$tenTK = $user['TenTaiKhoan'];
										$quyen = $user['Quyen'];
									@endphp
									<li><a href="{{ route('dangXuat') }}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
									@if (!empty($quyen))
										<li><a href="{{ route('/dashboard') }}"><i class="fa fa-users"></i>Trang quản lý</a></li>
									@endif
{{--									<li><a href="{{ route('/thong-tin-tai-khoan') }}"><i class="fa fa-users"></i> {{ htmlspecialchars($tenTK) }}</a></li>--}}
								@else
									<li><a href="{{ route('dangNhap') }}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					@yield('header-bottom')
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<section id="slider">
		<div class="container">
			<div class="row">
				@yield('slider')
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row">
				@yield('content')
			</div>
		</div>
	</section>

	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>E</span>-lectronic</h2>
							<p>Luôn phục vụ mọi lúc mọi nơi</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Liên hệ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Trợ giúp khách hàng</a></li>
								<li><a href="#">Số điện thoại</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Sản phẩm chính</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Laptop</a></li>
								<li><a href="#">Máy lạnh</a></li>
								<li><a href="#">Tivi</a></li>
								<li><a href="#">Quạt</a></li>
								<li><a href="#">Điều hòa</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Chính sách</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Chính sách bảo hành</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Thông tin về cửa hàng</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Thông tin công ty</a></li>
								<li><a href="#">Địa chỉ</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Thực tập tốt nghiệp</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="#">Nhóm 59</a></span></p>
				</div>
			</div>
		</div>
	</footer><!--/Footer-->

    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
	<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
	<script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
	<script src="{{ asset('frontend/ckeditor/ckeditor.js') }}"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	{{-- Tính tiền giao hàng --}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('.TinhPhiGiaoHang').click(function(){
				var MaThanhPho = $('.MaThanhPho').val();
				var MaQuanHuyen = $('.MaQuanHuyen').val();
				var MaXaPhuong = $('.MaXaPhuong').val();
				var _token = $('input[name="_token"]').val();
				if(MaXaPhuong == null){
					alert('Chọn địa điểm để tính phí vận chuyển');
				}else{
					$.ajax({
					url: '{{ route('/TinhPhiGiaoHang') }}',
					method: 'POST',
					data:{
						MaThanhPho:MaThanhPho,
						MaQuanHuyen:MaQuanHuyen,
						MaXaPhuong:MaXaPhuong,
						_token:_token
					},
					success:function(data){
						location.reload();
					}
				});
				}
			});
		});
	</script>
	{{-- Lọc báo cáo doanh thu --}}
	{{-- Chọn địa điểm --}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ChonDiaDiem').on('click',function(){
			var action = $(this).attr('id');
			var ma_id = $(this).val();
			var _token = $('input[name="_token"]').val();
			var result = '';

			if(action=='MaThanhPho'){
				result = 'MaQuanHuyen';
			}else{
				result = 'MaXaPhuong';
			}
			$.ajax({
				url : '{{ route('/ChonDiaDiem') }}',
				method: 'POST',
				data:{
					action:action,
					ma_id:ma_id,
					_token:_token
				},
				success:function(data){
					$('#'+result).html(data);
				}});
    		});
		});
	</script>
	<script>
		$(document).ready(function(){
			var MaDanhMuc = $('.tabs_pro').data('id');
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url: '{{ route('/product-tabs') }}',
				method: "POST",
				data: {
					MaDanhMuc:MaDanhMuc,
					_token:_token,
				},
				success:function(data){
					$('#tabs_product').html(data);
				}
			});

			$('.tabs_pro').click(function(){
				var MaDanhMuc = $(this).data('id');
				var _token = $('input[name="_token"]').val();
				$.ajax({
					url: '{{ route('/product-tabs') }}',
					method: "POST",
					data: {
						MaDanhMuc:MaDanhMuc,
						_token:_token,
					},
					success:function(data){
						$('#tabs_product').html(data);
					}
				});
			});
		});
	</script>
	{{-- Create cart --}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ThemGioHang').click(function(){
				var id = $(this).data('id_product');
				var cart_product_id = $('.cart_product_id_' + id).val();
				var cart_product_name = $('.cart_product_name_' + id).val();
				var cart_product_image = $('.cart_product_image_' + id).val();
				var cart_product_price = $('.cart_product_price_' + id).val();
				var cart_product_qty = $('.cart_product_qty_' + id).val();
				var cart_product_height = $('.cart_product_height_' + id).val();
				var cart_product_width = $('.cart_product_width_' + id).val();
				var cart_product_thick = $('.cart_product_thick_' + id).val();
				var cart_product_weight = $('.cart_product_weight_' + id).val();
				var cart_product_guarantee = $('.cart_product_guarantee_' + id).val();
				var cart_product_quantity = $('.cart_product_quantity_' + id).val();
				var _token = $('input[name="_token"]').val();

				$.ajax({
					url: '{{ route('/ThemGioHang') }}',
					method: 'POST',
					data:{
						cart_product_id:cart_product_id,
						cart_product_name:cart_product_name,
						cart_product_image:cart_product_image,
						cart_product_price:cart_product_price,
						cart_product_qty:cart_product_qty,
						cart_product_height:cart_product_height,
						cart_product_width:cart_product_width,
						cart_product_thick:cart_product_thick,
						cart_product_weight:cart_product_weight,
						cart_product_guarantee:cart_product_guarantee,
						cart_product_quantity:cart_product_quantity,
						_token:_token
					},
					success:function(data){
						swal({
							title: "Đã thêm sản phẩm vào giỏ hàng",
							text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",

							showCancelButton: true,
							cancelButtonText: "Xem tiếp",
							confirmButtonClass: "btn-success",
							confirmButtonText: "Đi đến giỏ hàng",
							closeOnConfirm: false
							},
						function() {
							window.location.href = "{{ route('/HienThiGioHang') }}";
						});
					}
				});
			});
		});
	</script>
	{{-- Update cart Item --}}
	<script type="text/javascript">
		$(document).on('click', '.updateCartItem', function(){
			if($(this).hasClass('qtyPlus')){
				var quantity = $(this).data('qty');
				var soluongMax = $(this).data('soluonghientai');
				if(quantity < soluongMax){
					new_qty = parseInt(quantity)+1;
				}else{
					sweetAlert("Cảnh báo", "Số lượng bên trong cửa hàng không đủ", "error");
				}
			}
			if($(this).hasClass('qtyMinus')){
				var quantity = $(this).data('qty');
				if(quantity<=1){
					sweetAlert("Cảnh báo", "Số lượng sản phẩm phải lớn hơn 1", "error");
				}else{
					new_qty = parseInt(quantity)-1;
				}
			}
			var cartid = $(this).data('cartid');
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url: '{{ route('/ThayDoiSoLuong') }}',
				method: 'POST',
				data:{
					cartid:cartid,
					qty:new_qty,
					_token:_token
				},
				success:function(data){
					location.reload();
				}
			});
		});
	</script>
	{{-- Đánh giá --}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ThemDanhGia').click(function(){
				var id = $(this).data('masanpham');
				var MaSanPham = $('.MaSanPham_' + id).val();
				var NoiDung = $('.NoiDung_' + id).val();
				var _token = $('input[name="_token"]').val();
				var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
				$.ajax({
					url: '{{ route('/DanhGia') }}',
					method: 'POST',
					data:{
						MaSanPham:MaSanPham,
						NoiDung:NoiDung,
						SoSao:ratingValue,
						_token:_token
					},
				});
			});
		});
	</script>
	{{-- 5 ngôi sao sáng --}}
	<script type="text/javascript">
		$(document).ready(function(){
		/* 1. Visualizing things on Hover - See next part for action on click */
		$('#stars li').on('mouseover', function(){
			var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

			// Now highlight all the stars that's not after the current hovered star
			$(this).parent().children('li.star').each(function(e){
			if (e < onStar) {
				$(this).addClass('hover');
			}
			else {
				$(this).removeClass('hover');
			}
			});

		}).on('mouseout', function(){
			$(this).parent().children('li.star').each(function(e){
			$(this).removeClass('hover');
			});
		});
		/* 2. Action to perform on click */
		$('#stars li').on('click', function(){
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('selected');
			}
			// JUST RESPONSE (Not needed)
			// var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
			// var msg = "";
			// if (ratingValue > 1) {
			// 	msg = "Thanks! You rated this " + ratingValue + " stars.";
			// }
			// else {
			// 	msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
			// }
			// responseMessage(msg);
		});
		});
		// function responseMessage(msg) {
		// $('.success-box').fadeIn(200);
		// $('.success-box div.text-message').html("<span>" + msg + "</span>");
		// }
	</script>
	@yield('js-custom')
</body>
</html>
