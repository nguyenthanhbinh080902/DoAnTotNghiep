@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Báo cáo {{ $fileName }}
        </div>
        <div class="table-responsive">
        <table class="table table-striped b-t b-light table-bordered" style="text-align:center;">
                <thead>
                    <tr >
                        <th rowspan="2" >Mã sản phẩm</th>
                        <th rowspan="2" style="text-align:center;">Tên sản phẩm</th>
                        <th rowspan="2">Tồn đầu kỳ</th>
                        <th colspan="3" style="text-align:center;">Nhập trong kỳ</th>
                        <th colspan="3" style="text-align:center;">Xuất trong kỳ</th>
                        <th colspan="3" style="text-align:center;">Tồn cuối kỳ</th>
                    </tr>
                    <tr>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Thành tiền</th>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Thành tiền</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Thành tiền</th>
                    </tr>                  
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            @php
                             $n = 0;

                            @endphp
                            @foreach ($row as $cell)
                                @php
                                 $n += 1; 
                                @endphp
                                @if ($n != 3)
                                    <td>{{ $cell }}</td>
                                @endif
                                
                                
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <footer class="panel-footer">
                <div class="row">
                <div class="col-sm-5 text-center">
                </div>
                <div class="col-sm-7 text-right text-center-xs">                
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
                </div>
            </footer>
        </div>

        <div class="row w3-res-tb">
                <div class="col-sm-1">

                </div>
                <div class="col-sm-11">
                    <div class="card">
                        <div class="card-header">
                            Biểu đồ
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <a href="{{ route('xemBaoCao') }}"><button class="btn btn-sm btn-info">Quay lại</button></a>
</div>   

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart2').getContext('2d');
        var data = {!! json_encode($bieuDo) !!};
        
        console.log(data); 

        var tenDanhMuc =Object.keys(data);
        var tong =Object.values(data);

        var tongNhap =tong.map(function(item){ return item.tongNhap; });
        var tongXuat =tong.map(function(item){ return item.tongXuat; });
        var tongTon =tong.map(function(item){ return item.tongTon; });

        var myChart = new Chart(ctx, {
            type: 'bar', // Hoặc 'doughnut'
            data: {
                labels: tenDanhMuc,
                datasets: [
                    {
                        label: 'Số Lượng Nhập',
                        data: tongNhap,
                        backgroundColor: '#FFCCCC',
                        borderColor: '#FF3333',
                        borderWidth: 1
                    },
                    {
                        label: 'Số Lượng Xuất',
                        data: tongXuat,
                        backgroundColor: '#CCFFCC',
                        borderColor: '#00FF00',
                        borderWidth: 1
                    },
                    {
                        label: 'Số Lượng Tồn',
                        data: tongTon,
                        backgroundColor: '#FFFFCC',
                        borderColor: '#FFFF00',
                        borderWidth: 1
                    }
                ]
            },
        });
    });
</script>  
@endsection