@extends('layouts.admin')

@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/user/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm thành viên
            </div>
            <div class="card-body">
                <form action="{{ url('admin/user/store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h6>
                            <label>Họ và tên:</label>
                        </h6>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="text-danger mb-1">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    <div class="form-group">
                        <h6>
                            <label>Email:</label>
                        </h6>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger mb-1">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    <div class="form-group">
                        <h6>
                            <label>Mật khẩu:</label>
                        </h6>
                        <input class="form-control" type="password" name="password">
                    </div>
                    @error('password')
                        <div class="text-danger mb-1">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    <div class="form-group">
                        <h6>
                            <label for="password_confirm">Xác nhận mật khẩu:</label>
                        </h6>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirm">
                    </div>

                    <div class="form-group">
                        <h6>
                            <label>Nhóm quyền:</label>
                        </h6>
                        <select class="form-control select2_init" multiple="multiple" name="role_id[]">
                            <option>Chọn quyền</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="text-danger mb-1">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <button type="submit" name="btn_add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/user/add/add.js') }}"></script>
@endsection
