@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm quyền hạn
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" id="themQH" action="{{ Route('them-quyen-han')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Chọn vai trò:</label>
                            <select class="form-control" id="tenQuyen" name="tenQuyen" style="width:100%">
                                @if(isset($quyenTK))
                                    @foreach($quyenTK as $i)
                                        <option value="{{ $i->MaPhanQuyen }}">{{ $i->TenPhanQuyen }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('tenquyen')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="quyen">Chọn quyền hạn:</label>

                            <select class="form-control" id="MaQuyen" name="MaQuyen" style="width:100%">
                                @if(isset($quyen))
                                    @foreach($quyen as $q)
                                        <option value="{{ $q->MaVaiTro }}">{{ $q->TenVaiTro }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Thêm</button>
                    </form>
                    <!-- <a href="{{ route('lietKeTK') }}"><button class="btn btn-info" style="margin-top:5px;">Trở lại</button></a> -->
                    <div class="table-responsive">
                        <p class="head1">Danh sách quyền hạn</p>
                        <table id="phieuNhapTable" class="table table-striped b-t b-light">
                            <thead>
                                <tr>   
                                    <td>Tên vai trò</td>
                                    <td>Tên quyền hạn</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#MaQuyen').select2();
        $('#themQH').on('submit', function(e) {
            e.preventDefault(); 

            var formData = $(this).serialize();  

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 800
                            });


                        
                            var newRow = `
                                <tr>
                                    <td>${data.tenQuyen}</td>
                                    <td>${data.tenQH}</td>
                                </tr>
                            `;
                            $('#phieuNhapTable tbody').append(newRow);
                        
                        // $('#themQH')[0].reset();
                    } else {
                        Swal.fire({
                                icon: 'error',
                                title: 'Thất bại',
                                text: 'Thêm thất bại: ' + data.message,
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