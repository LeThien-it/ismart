@extends("layouts.admin")

@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/user/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('user.update',['id' => $user->id ]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}" id="name">
                    </div>
                    @error('name')
                        <div class="text-danger mb-1">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}"  disabled id="email">
                    </div>
                    @error('email')
                        <div class="text-danger mb-1">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    
                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select class="form-control select2_init" id="" multiple="multiple" name="role_id[]">
                            @foreach ($roles as $role)
                                <option {{ $roleOfUser->contains('id',$role->id) ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
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

