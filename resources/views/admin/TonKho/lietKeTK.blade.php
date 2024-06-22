@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê sản phẩm trong kho
        </div>
        <div class="row w3-res-tb" style="margin-left: 2%">

            <a href="{{ route('xemPN')}}"><button class="btn btn-info">Xem phiếu nhập</button></a>
            <a href="{{ route('xemPX')}}"><button class="btn btn-info">Xem phiếu xuất</button></a>
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng hiện tại</th>
                                <th>Số lượng bán</th>
                                <th>Số lượng trong kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTK as $sp)
                                <tr>
                                    <td>{{ $sp->TenSanPham }}</td>
                                    <td>{{ $sp->SoLuongHienTai }}</td>
                                    <td>{{ $sp->SoLuongBan }}</td>
                                    <td>{{ $sp->SoLuongTrongKho }}</td>

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
                            {{ $dataTK->links('vendor.pagination.bootstrap-4') }}
                            </ul>
                        </div>
                        </div>
                    </footer>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Biểu đồ
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
        var labels = {!! json_encode($labels) !!};
        var data = {!! json_encode($data) !!};

        console.log(labels); 
        console.log(data);

        var myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số Lượng Trong Kho',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
        });
    });
</script>
@endsection
