@extends('admin_layout')
@section('admin_content')
<div class="market-updates">
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-2">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-eye"> </i>
            </div>
             <div class="col-md-8 market-update-left">
             <h4>Khách</h4>
            <h3>13,500</h3>
          </div>
          <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-users" ></i>
            </div>
            <div class="col-md-8 market-update-left">
            <h4>Người dùng</h4>
                <h3>1,250</h3>
            </div>
          <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-3">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-usd"></i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>Bán</h4>
                <h3>1,500</h3>
            </div>
          <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-4">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>Đặt hàng</h4>
                <h3>1,500</h3>
            </div>
          <div class="clearfix"> </div>
        </div>
    </div>
   <div class="clearfix"> </div>
</div>
<div class="container-fluid">
    <style type="text/css">
        p.title_thongke {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    <div class="row">
        <p class="title_thongke">Thống kê đơn hàng doanh số</p>
        <form autocomplete="off">
            {{ csrf_field() }}
            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control" ></p>
                <input style="margin-top: 5px" type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
            </div>
            <div class="col-md-2">
                <p>Date: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>
                    Lọc theo:
                    <select class="dashoard-filter form-control">
                        <option value="">---Chọn---</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">tháng trước</option>
                        <option value="thangnay">tháng ngày</option>
                        <option value="3thangtruoc">3 tháng trước</option>
                        <option value="365ngayqua">365 ngày qua</option>
                    </select>
                </p>
            </div>
        </form>
    </div>
    <div class="col-sm-12">
        <p class="title_thongke">Biểu đồ thống kê doanh số và lợi nhuận</p>
        <div id="chart" style="height: 350px;"></div>
    </div>
    <div class="col-sm-12">
        <p class="title_thongke">Biểu đồ thống kê số đơn hàng và số sản phẩm</p>
        <div id="chart2" style="height: 350px;"></div>
    </div>
</div>
@endsection
