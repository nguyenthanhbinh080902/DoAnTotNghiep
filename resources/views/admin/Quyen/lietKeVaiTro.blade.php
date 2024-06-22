@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê vai trò
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
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>                     
                        <th>Tên vai trò</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        <tr>
                            <td><input type="text" class="form-control" id="tenVaiTro_{{$i->MaPhanQuyen}}" value="{{ $i->TenPhanQuyen }}"></td>
                            <td>
                            <a href="javascript:void(0);" class="update-btn" data-id="{{ $i->MaPhanQuyen }}">Cập nhật</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.update-btn').on('click', function() {
        var MaPhanQuyen = $(this).data('id');
        var TenPhanQuyen = $('#tenVaiTro_' + MaPhanQuyen).val();

        $.ajax({
            url: '{{ route('update.vaitro') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                MaPhanQuyen: MaPhanQuyen,
                TenPhanQuyen: TenPhanQuyen,
            },
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Cập nhật thành công',
                            showConfirmButton: false,
                            timer: 800
                        });
                } else {
                    Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Cập nhật thất bại: ' + data.message,
                            showConfirmButton: true
                        });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: 'Bạn nhập thiếu thông tin!!!Mời bạn kiểm tra lại thông tin!!!',
                        showConfirmButton: true
                    });
            }
        });
    });
});
</script>
@endsection  