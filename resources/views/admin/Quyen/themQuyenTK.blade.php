@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm vai trò
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" id="from" action="/xuLyThemQTK" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="tenquyen">Tên vai trò:</label>
                            <input class="form-control" type="text" id="tenquyen" name="tenquyen" value="{{ old('tenquyen') }}">
                        </div>
                        @error('tenquyen')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
