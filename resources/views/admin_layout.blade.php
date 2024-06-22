<!DOCTYPE html>
<head>
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Admin Page" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}" >
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('backend/css/style-responsive.css') }}" rel="stylesheet"/>
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{ asset('backend/css/font.css') }}" type="text/css"/>
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/morris.css') }}" type="text/css"/> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- calendar -->
    <link rel="stylesheet" href="{{ asset('backend/css/monthly.css') }}">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{ asset('backend/js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('backend/js/raphael-min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/morris.js') }}"></script> --}}
    <script src="{{ asset('backend/js/jquery.scrollTo.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <!-- morris JavaScript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

</head>
<body>
@php
$user = session('user');
$quyen = $user['Quyen'];

@endphp
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">
            <a href="{{ route('/') }}" class="logo">
                SHOP
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->

        <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder=" Search">
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="" src="{{ asset('backend/images/user.png') }}">
                        <span class="username">
                  @php
                      $tenTaiKhoan = Session::get('TenTaiKhoan');
                      if ($tenTaiKhoan) {
                        echo $tenTaiKhoan;
                      }
                  @endphp
                </span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="{{ route('/Test') }}"><i class=" fa fa-suitcase"></i>Trang cá nhân</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                        <li><a href="{{ route('dangXuat') }}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    @if ($quyen == "Quản trị viên cấp cao")
    <aside>
        <div id="sidebar" class="nav-collapse">
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                    <li>
                        <a class="active" href="{{ route('/dashboard') }}">
                            <span>Trang quản lý</span>
                        </a>
                    </li>
                    
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý tài khoản</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ route('taoTK') }}">+ Tạo tài khoản</a></li>
                            <li><a href="{{ route('lietKeTK') }}">+ Liệt kê tài khoản</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý phân quyền</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ route('themQuyenTK') }}">+ Thêm vai trò mới</a></li>
                            <li><a href="{{ route('lietKeVaiTro') }}">+ Liệt kê vai trò</a></li>
                            <li><a href="{{ route('themQuyen') }}">+ Phân quyền</a></li>
                            <li><a href="{{ route('lietKeQH') }}">+ Liệt kê quyền hạn</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý danh mục</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý danh mục thương hiệu</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/trang-them-thdm') }}">+ Thêm danh mục </a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/trang-liet-ke-thtdm') }}">+ Liệt kê danh mục </a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý danh mục TSKT</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangThemDanhMucTSKT') }}">+ Thêm danh mục </a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangLietKeDanhMucTSKT') }}">+ Liệt kê danh mục </a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý danh mục bài viết</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/TrangThemDanhMucBV') }}">+ Thêm danh mục </a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/TrangLietKeDanhMucBV') }}">+ Liệt kê danh mục </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý thương hiệu</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ route('/TrangThemThuongHieu') }}">+ Thêm thương hiệu sản phẩm</a></li>
                            <li><a href="{{ route('/TrangLietKeThuongHieu') }}">+ Liệt kê thương hiệu sản phẩm</a></li>
                        </ul>
                    </li>


                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý nhà cung cấp</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ route('themNCC') }}">+ Thêm nhà cung cấp</a></li>
                            <li><a href="{{ route('lietKeNCC') }}">+ Liệt kê nhà cung cấp</a></li>

                        </ul>
                    </li>


                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý sản phẩm</span>
                        </a>
                        <ul class="sub">

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý loại sản phẩm</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangThemDanhMuc') }}">+ Thêm loại sản phẩm</a></li>
                                    <li  style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangLietKeDanhMuc') }}">+ Liệt kê loại sản phẩm</a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý sản phẩm</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangThemSanPham') }}">+ Thêm sản phẩm</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangLietKeSanPham') }}">+ Liệt kê sản phẩm</a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý TSKT</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangThemTSKT') }}">+ Thêm TSKT</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangLietKeTSKT') }}">+ Liệt kê TSKT</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý kho</span>
                        </a>

                        <ul class="sub">

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý phiếu nhập</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('lapPN') }}">+ Lập phiếu nhập</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('xemPN') }}">+ Liệt kê phiếu nhập</a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý phiếu xuất</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('taoPX') }}">+ Lập phiếu xuất</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('xemPX') }}">+ Liệt kê phiếu xuất</a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý tồn kho</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('lietKeTonKho') }}">+ Liệt kê tồn kho</a></li>
                                    <!-- <li><a href="{{ route('xemPTH') }}">+ Liệt kê phiếu trả hàng</a></li> -->
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('xemBaoCao') }}">+ Tạo báo cáo xuất nhập tồn</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>



                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý đơn hàng</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ Route('/TrangLietKeDonHang') }}">Liệt kê đơn hàng</a></li>
                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý giảm giá</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/them-phieu-giam-gia') }}">+ Thêm phiếu giảm giá</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/liet-ke-phieu-giam-gia') }}">+ Liệt kê phiếu giảm giá</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/tao-chuong-trinh-giam-gia') }}">+ Thêm chương trình giảm giá</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ Route('/chuong-trinh-giam-gia') }}">+ Liệt kê chương trình giảm giá</a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <span>Quản lý phí giao hàng</span>
                                </a>
                                <ul class="sub">
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangThemPhiGiaoHang') }}">+ Thêm phí giao hàng</a></li>
                                    <li style="margin-left: 10%; list-style: none"><a href="{{ route('/TrangLietKePhiGiaoHang') }}">+ Liệt kê phí giao hàng</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý bài viết</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ Route('/TrangThemBaiViet') }}">+ Thêm bài viết</a></li>
                            <li><a href="{{ Route('/TrangLietKeBaiViet') }}">+ Liệt kê bài viết</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý phản hồi khách hàng</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ Route('/TrangLietKeDanhGia') }}">+ Liệt kê đánh giá sản phẩm</a></li>
                            <li><a href="{{ Route('/TrangLietKeBinhLuan') }}">+ Liệt kê bình luận</a></li>
                        </ul>
                    </li>



                    <li class="sub-menu">
                        <a href="javascript:;">
                            <span>Quản lý báo cáo doanh thu</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{ Route('/TrangLietKeBCDT') }}">+ Liệt kê báo cáo doanh thu</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    @else
        @php
            $data = session('path');
        @endphp
        <aside>
            <div id="sidebar" class="nav-collapse">
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        @foreach($data as $i)
                        <li>
                            <a class="" href="{{ route($i->VaiTro) }}">
                                <span>{{ $i->TenVaiTro }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>
    @endif
    
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @yield('admin_content')
        </section>
        <div class="footer">
            <div class="wthree-copyright">
                <p>Sản phẩm của nhóm số 59<a href=""> Đồ án tốt nghiệp</a></p>
            </div>
        </div>
    </section>
    <!--main content end-->
</section>
<script src="{{ asset('backend/js/bootstrap.js') }}"></script>
<script src="{{ asset('backend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('backend/js/scripts.js') }}"></script>
<script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('backend/js/monthly.js') }}"></script>
<script src="{{ asset('frontend/ckeditor/ckeditor.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
{{-- datepicker --}}
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow",
        });

        $( "#datepicker2" ).datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow",
        });

        $( "#datepicker3" ).datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow",
        });

        $( "#datepicker4" ).datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow",
        });
    });
</script>
{{-- Chọn địa điểm giao hàng --}}
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
                }
            });
        });
    });
</script>
{{-- Chọn danh thông số kỹ thuật --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.chonDanhMucTSKT').on('click',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action=='DanhMucCha'){
                result = 'DanhMucCon';
            }else if(action=='DanhMucCon'){
                result = 'DanhMucTSKT';
            }else if(action=='DanhMucTSKT'){
                result = 'ThongSoKyThuat';
            }

            $.ajax({
                url : '{{ route('/ChonDanhMucTSKT') }}',
                method: 'POST',
                data:{
                    action:action,
                    ma_id:ma_id,
                    _token:_token
                },
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
    });
</script>
{{-- Thêm TSKT cho sản phẩm --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.ThemTSKTChoSanPham').on('click',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action=='DanhMucCha'){
                result = 'DanhMucCon';
            }else if(action=='DanhMucCon'){
                result = 'DanhMucTSKT';
            }

            $.ajax({
                url : '{{ route('/ThemTSKTChoSanPham') }}',
                method: 'POST',
                data:{
                    action:action,
                    ma_id:ma_id,
                    _token:_token
                },
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
    });
</script>
{{-- Sửa TSKT thuộc sản phẩm --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.SuaTSKTChoSanPham').on('click',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action=='DanhMucCha'){
                result = 'DanhMucCon';
            }else if(action=='DanhMucCon'){
                result = 'DanhMucTSKT';
            }

            $.ajax({
                url : '{{ route('/SuaTSKTChoSanPham') }}',
                method: 'POST',
                data:{
                    action:action,
                    ma_id:ma_id,
                    _token:_token
                },
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
    });
</script>
{{-- Hiển thị báo cáo doanh thu --}}
{{-- <script>
    $(document).ready(function(){
        $('#btn-baocaodoanhthu').click(function(){
            var _token = $('input[name="_token"]').val();
            var from_date = $('#datepicker3').val();
            var to_date = $('#datepicker4').val();
            alert(to_date);
            $.ajax({
                url: '{{ Route('/BaoCaoDoanhThuTheoDate') }}',
                method: 'POST',
                data: {
                    _token:_token,
                    from_date:from_date,
                    to_date:to_date,
                },
            });
        });
    });
</script> --}}
{{-- Gửi dữ liệu tới biểu đồ --}}
<script type="text/javascript">
    $(document).ready(function(){

        chart30daysorder();
        var chart = new Morris.Bar({
            element: 'chart',
            parseTime: false,
            hideHover: 'auto',
            fillOpacity: 0.3,
            lineColors:['#819C79', '#fc8710', '#FF6541', '#766B56'],
            xkey: 'period',
            ykeys: ['profit', 'sales'],
            labels: ['Lợi nhuận', 'Doanh số']
        });

        var chart2 = new Morris.Line({
            element: 'chart2',
            parseTime: false,
            hideHover: 'auto',
            fillOpacity: 0.3,
            lineColors:['#819C79', '#fc8710', '#FF6541', '#766B56'],
            xkey: 'period',
            ykeys: ['order', 'quantity'],
            labels: ['Số lượng đơn hàng', 'Số lượng sản phẩm']
        });

        function chart30daysorder(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ Route('/days-order') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token:_token,
                },
                success:function(data) {
                    chart.setData(data);
                    chart2.setData(data);
                },
            });
        }

        $('#btn-dashboard-filter').click(function(){
            var _token = $('input[name="_token"]').val();
            var from_date = $('#datepicker').val();
            var to_date = $('#datepicker2').val();
            $.ajax({
                url: '{{ Route('/filter-by-date') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token:_token,
                    from_date:from_date,
                    to_date:to_date,
                },
                success:function(data) {
                    chart.setData(data);
                    chart2.setData(data);
                },
            });
        });

        $('.dashoard-filter').change(function(){
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('/dashboard-filter') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    dashboard_value:dashboard_value,
                    _token:_token,
                },
                success:function(data){
                    chart.setData(data);
                    chart2.setData(data);
                }
            });
        })
    });
</script>
{{-- ChangeToSlug --}}
<script type="text/javascript">
    function ChangeToSlug(){
        var slug;
        //Lấy text từ thẻ input title
        slug = document.getElementById("slug").value;
        slug = slug.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('convert_slug').value = slug;
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        //BOX BUTTON SHOW AND CLOSE
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        //CHARTS
        function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
        }

        graphArea2 = Morris.Area({
            element: 'hero-area',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth:true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity:0.85,
            data: [
                {period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
                {period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
                {period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
                {period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
                {period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
                {period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
                {period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
                {period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
                {period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},

            ],
            lineColors:['#eb6f6f','#926383','#eb6f6f'],
            xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });
    });
</script>
<script type="text/javascript">
    $(window).load( function() {
        $('#mycalendar').monthly({
            mode: 'event',
        });

        $('#mycalendar2').monthly({
            mode: 'picker',
            target: '#mytarget',
            setWidth: '250px',
            startHidden: true,
            showTrigger: '#mytarget',
            stylePast: true,
            disablePast: true
        });
        switch(window.location.protocol) {
            case 'http:':
            case 'https:':
                // running on a server, should be good.
                break;
            case 'file:':
                alert('Just a heads-up, events will not work when run locally.');
        }
    });
</script>
@yield('js-custom')
</body>
</html>
