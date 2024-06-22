@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
         Thông tin giao hàng
      </div>
      <div class="table-responsive">
        @php
            $status = Session::get('status');
            if ($status) {
                echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$status.'</span>';
                Session::put('status', null);
            }
        @endphp
        @php
          $total = 0;
          $total_after = 0;
          $total_after_coupon = 0;
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên người nhận</th>
              <th>Email</th>
              <th>Tiền giao hàng</th>
              <th>Địa chỉ</th>
              <th>Số điện thoại</th>
              <th>Ghi chú</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $allDonHang->GiaoHang->TenNguoiNhan }}</td>
              <td>{{ $allDonHang->Email }}</td>
              <td>{{ number_format($allDonHang->GiaoHang->TienGiaoHang, 0, '', '.') }} đ</td>
              <td>{{ $allDonHang->GiaoHang->DiaChi }}</td>
              <td>{{ $allDonHang->GiaoHang->SoDienThoai }}</td>
              <td>{{ $allDonHang->GiaoHang->GhiChu ?? 'Không có ghi chú nào' }}</td>
              <td>
                <a href="{{ route('/TrangSuaThongTinGiaoHang', [$allDonHang->GiaoHang->MaGiaoHang, $allDonHang->order_code]) }}">
                  <i style="font-size: 20px; width: 100%; text-align: center; font-weight: bold; color: green; margin-bottom: 15px" class="fa fa-pencil-square-o text-success text-active"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
         Thông tin phiếu giảm giá
      </div>
      <div class="table-responsive">
        @php
            $status = Session::get('status');
            if ($status) {
                echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$status.'</span>';
                Session::put('status', null);
            }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên Phiếu giảm giá</th>
              <th>Số tiền | Phần trămm giảm</th>
              <th>Trị giá</th>
              <th>Mã code</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          @if ($allDonHang->MaGiamGia != 0)
            <tbody>
              <tr>
                <td>{{ $allDonHang->PhieuGiamGia->TenMaGiamGia }}</td>
                @if ($allDonHang->PhieuGiamGia->DonViTinh == 1)
                  <td>Phiếu giảm giá theo số tiền</td>
                  <td>{{ number_format($allDonHang->PhieuGiamGia->TriGia, 0, '', '.') }} đ</td>
                @elseif ($allDonHang->PhieuGiamGia->DonViTinh == 2)
                  <td>Phiếu giảm giá theo phần trăm</td>
                  <td>{{ $allDonHang->PhieuGiamGia->TriGia }} %</td>
                @endif
                <td>{{ $allDonHang->PhieuGiamGia->MaCode }}</td>
                <td>
                  <a onclick="return confirm('Bạn có muốn xóa phiếu giảm giá thuộc đơn hàng này không?')" href="{{ route('/XoaPhieuGiamGiaThuocDonHang', [$allDonHang->MaDonHang, $allDonHang->MaGiamGia]) }}">
                    <i style="font-size: 28px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          @elseif ($allDonHang->MaGiamGia == '')
            <tr>
              <td colspan="5">Không dùng mã giảm giá trong đơn hàng này</td>
            </tr>       
          @endif
        </table>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
         Liệt kê chi tiết đơn hàng
      </div>
      <div class="table-responsive">
        @php
            $status = Session::get('status');
            if ($status) {
                echo '<span style="font-size: 17px; width: 100%; text-align: center; font-weight: bold; color: red;" class="text-alert">'.$status.'</span>';
                Session::put('status', null);
            }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên sản phẩm</th>
              <th>Hình ảnh</th>
              <th>Số lượng</th>
              <th>Giá sản phẩm</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allChiTietDonHang as $key => $value)
            @php
              $total += $value->GiaSanPham * $value->SoLuong;
            @endphp
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $value->SanPham->TenSanPham }}</td>
              <td><img src="{{ asset('upload/sanPham/'.$value->SanPham->HinhAnh) }}" height="100px" width="150px"></td>
              <td>
                <form action="{{ route('/SuaSoLuongSanPham', [$value->MaCTDH, $value->order_code]) }}" method="POST">
                  {{ csrf_field() }}
                  <input type="number" min="1" {{ $allDonHang->TrangThai!=1 ? 'disabled' : ''  }} value="{{ $value->SoLuong }}" name="SoLuongSanPham">
                  <button type="submit" class="btn btn-default">Cập nhật</button>
                </form>
              </td>
              <td>{{ number_format($value->GiaSanPham, 0, '', '.') }} đ</td>
              <td>
                <a onclick="return confirm('Bạn có muốn xóa sản phẩm {{ $value->SanPham->TenSanPham }} thuộc đơn hàng này không?')" href="{{ route('/XoaChiTietDonHang', [$value->MaCTDH, $value->order_code]) }}">
                  <i style="font-size: 28px; width: 100%; text-align: center; font-weight: bold; color: red;" class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="8">
                Tiền giỏ hàng: {{ number_format($total, 0,',','.').'đ' }}<br>         
                Phí ship: {{ number_format($allDonHang->GiaoHang->TienGiaoHang, 0,',','.').'đ' }}<br>
                @php
                $total_coupon = 0;
                @endphp
                @if ($allDonHang->MaGiamGia != 0 && $allDonHang->PhieuGiamGia->DonViTinh == 1 )
                  @php
                    echo 'Mã giảm giá theo tiền: '.number_format($allDonHang->PhieuGiamGia->TriGia, 0,',','.').'đ'.'<br>';
                    $total_after = $total - $allDonHang->PhieuGiamGia->TriGia + $allDonHang->GiaoHang->TienGiaoHang;
                  @endphp
                @elseif ($allDonHang->MaGiamGia != 0 && $allDonHang->PhieuGiamGia->DonViTinh == 2)
                  @php
                    $total_after_coupon = $total*$allDonHang->PhieuGiamGia->DonViTinh/100;
                    echo 'Mã giảm giá '.$allDonHang->PhieuGiamGia->TriGia.'%: '   .number_format($total_after_coupon, 0,',','.').'đ'.'<br>';
                    $total_after = $total - $total_after_coupon + $allDonHang->GiaoHang->TienGiaoHang;
                  @endphp
                @elseif ($allDonHang->MaGiamGia == 0)
                  @php
                    echo 'Đơn hàng không áp dụng phiếu giảm giá'.'<br>';
                    $total_after = $total + $allDonHang->GiaoHang->TienGiaoHang;
                  @endphp
                @endif
                Thanh toán: {{ number_format($total_after, 0,',','.').'đ' }}<br>           
              </td>
            </tr>
            <tr>
              <td colspan="8">
                @if ($allDonHang->TrangThai == 1)
                <form method="POST" action="{{ route('/SuaTrangThaiDonHang', [$allDonHang->MaDonHang, $allDonHang->order_code]) }}">
                  {{ csrf_field() }}
                  <select class="form-control ThayDoiTrangThaiDonHang" name="TrangThaiDonHang" >
                    <option value="">--Chọn hình thức đơn hàng--</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="1" selected>Đơn hàng vừa được tạo</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="2">Nhân viên giao hàng lấy đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="3">Khách hàng thanh toán đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="4">Khách hàng không nhận đơn hàng</option>
                  </select>
                  <button type="submit" style="margin-top: 10px" name="SuaTrangThaiDonHang" class="btn btn-info">Cập nhật trạng thái đơn hàng</button>
                </form>
                @elseif($allDonHang->TrangThai == 2)
                <form method="POST" action="{{ route('/SuaTrangThaiDonHang', [$allDonHang->MaDonHang, $allDonHang->order_code]) }}">
                  {{ csrf_field() }}
                  <select class="form-control order_details" name="TrangThaiDonHang" >
                    <option value="">--Chọn hình thức đơn hàng--</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="1">Đơn hàng vừa được tạo</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="2" selected>Nhân viên giao hàng lấy đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="3">Khách hàng thanh toán đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="4">Khách hàng không nhận đơn hàng</option>
                  </select>
                  <button type="submit" name="SuaTrangThaiDonHang" style="margin-top: 10px" class="btn btn-info">Cập nhật trạng thái đơn hàng</button>
                </form>
                @elseif($allDonHang->TrangThai == 3)
                <form>
                  {{ csrf_field() }}
                  <select class="form-control order_details" name="TrangThaiDonHang" >
                    <option value="">--Chọn hình thức đơn hàng--</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="1">Đơn hàng vừa được tạo - chưa xử lý</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="2">Nhân viên giao hàng lấy đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="3" selected>Khách hàng thanh toán đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="4">Khách hàng không nhận đơn hàng</option>
                  </select>
                  <button type="submit" style="margin-top: 10px" disabled name="SuaTrangThaiDonHang" class="btn btn-info">Cập nhật trạng thái đơn hàng</button>
                </form>
                @elseif($allDonHang->TrangThai == 4)
                <form>
                  {{ csrf_field() }}
                  <select class="form-control order_details" name="TrangThaiDonHang" >
                    <option value="TrangThaiDonHang">--Chọn hình thức đơn hàng--</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="1">Đơn hàng vừa được tạo - chưa xử lý</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="2">Nhân viên giao hàng lấy đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="3">Khách hàng thanh toán đơn hàng</option>
                    <option id="{{ $allDonHang->MaDonHang }}" value="4" selected>Khách hàng không nhận đơn hàng</option>
                  </select>
                  <button type="submit" style="margin-top: 10px" disabled name="SuaTrangThaiDonHang" class="btn btn-info">Cập nhật trạng thái đơn hàng</button>
                </form>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection