@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật phí giao hàng
            </header>
            <div class="panel-body">
                <div class="position-center">
                    @foreach ($phiGiaoHang as $key => $value)
                    <form role="form" action="{{ Route('/SuaPhiGiaoHang', [$value->MaPhiGiaoHang]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                           <label for="exampleInputPassword1">Chọn thành phố</label>
                            <select name="MaThanhPho" id="MaThanhPho" class="form-control input-lg m-bot15 ChonDiaDiem MaThanhPho">
                                <option value="" >--Chọn thành phố--</option>
                                @foreach ($allThanhPho as $key => $valueThanhPho)
                                @if ($value->MaThanhPho == $valueThanhPho->MaThanhPho)
                                    <option selected value="{{ $valueThanhPho->MaThanhPho }}" >{{ $valueThanhPho->TenThanhPho }}</option>
                                @else
                                    <option value="{{ $valueThanhPho->MaThanhPho }}" >{{ $valueThanhPho->TenThanhPho }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn quận huyện</label>
                            <select name="MaQuanHuyen" id="MaQuanHuyen" class="form-control input-lg m-bot15 ChonDiaDiem MaQuanHuyen">
                                <option value="" >--Chọn quận huyện--</option>
                                @foreach ($allQuanHuyen as $key => $valueQuanHuyen)
                                @if ($value->MaQuanHuyen == $valueQuanHuyen->MaQuanHuyen)
                                    <option selected value="{{ $valueQuanHuyen->MaQuanHuyen }}" >{{ $valueQuanHuyen->TenQuanHuyen }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn xã phường</label>
                            <select name="MaXaPhuong" id="MaXaPhuong" class="form-control input-lg m-bot15 MaXaPhuong">
                                <option value="" >--Chọn xã phường--</option>
                                @foreach ($allXaPhuong as $key => $valueXaPhuong)
                                @if ($value->MaXaPhuong == $valueXaPhuong->MaXaPhuong)
                                    <option selected value="{{ $valueXaPhuong->MaXaPhuong }}" >{{ $valueXaPhuong->TenXaPhuong }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tiền giao hàng</label>
                            <input type="text" value="{{ $value->SoTien }}" class="form-control @error('PhiGiaoHang') is-invalid @enderror" name="PhiGiaoHang" >
                        </div>
                        @error('PhiGiaoHang')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <button type="submit" name="SuaPhiGiaoHang" class="btn btn-info">Cập nhật Tiền giao hàng</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
