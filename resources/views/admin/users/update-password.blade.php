@extends('layouts.admin')

@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/user/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật mật khẩu người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('user.updatePassword', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password">Mật khẩu hiện tại:</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <div class="text-danger mb-1">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input class="form-control" type="password" name="new_password" id="password">
                        @error('new_password')
                            <div class="text-danger mb-1">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_confirm_password">Xác nhận mật khẩu:</label>
                        <input class="form-control" type="password" name="new_confirm_password" id="new_confirm_password">
                        @error('new_confirm_password')
                            <div class="text-danger mb-1">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/user/add/add.js') }}"></script>
@endsection
