@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật nhóm quyền
            </div>
            <div class="card-body">
                <form action="{{ route('role.update',$role->id) }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Tên nhóm quyền</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $role->name }}">
                            @error('name')
                                <div class="text-danger mb-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="desc">Mô tả nhóm quyền</label>
                            <input class="form-control" type="text" name="desc" id="desc" value="{{ $role->desc }}">
                            @error('desc')
                                <div class="text-danger mb-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" id="check_all">
                                    Chọn tất cả
                                </label>
                                @foreach ($permissionParents as $permissionParent)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <label>
                                                <input class="checkbox_wrapper" type="checkbox" value="">
                                            </label>
                                            Module {{ $permissionParent->name }}
                                        </div>

                                        <div class="row mx-0">
                                            @foreach ($permissionParent->permissionChildrens as $permissionChildren)
                                                <div class="card-body col-md-3">
                                                    <h6 class="card-title mb-0">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="permission_id[]"
                                                                value="{{ $permissionChildren->id }}"
                                                                class="checkbox_children" {{ $permissionIds->contains('id',$permissionChildren->id) ? 'checked' : '' }}>
                                                        </label>
                                                        {{ $permissionChildren->name }}
                                                    </h6>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                @error('permission_id')
                                    <div class="text-danger mb-1">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/role/add/add.js') }}"></script>
@endsection
