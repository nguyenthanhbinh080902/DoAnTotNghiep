@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê quyền hạn tài khoản
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-5">
                
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Tên vai trò</th>
                    <th>Tên quyền hạn</th>
                    <th>Quản lý quyền hạn</th>
                </tr>
                @foreach ($result as $tenPQ => $i)
                    <tr>
                        <td rowspan="{{ count($i) + 1 }}" style="border-right:1px solid #EEEEEE; vertical-align: middle;">{{ $tenPQ }}</td>
                    </tr>
                    @foreach ($i as $vaiTro)
                    <tr>
                        <td>{{ $vaiTro['TenVaiTro'] }}</td>
                        <td>
                        <a onclick="return confirm('Bạn có muốn xóa tài khoản {{ $vaiTro['TenVaiTro'] }} không?')" href="{{ route('xoaQH', ['id' => $vaiTro['MaQVT']]) }}"><i style="font-size: 20px; padding: 5px; color: red;" class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    
                    @endforeach
                    
                @endforeach
            </table>
            
        </div>
    </div>
</div>
@endsection  