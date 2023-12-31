@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <form class="form-inline" action="#">
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="input-group-text bg-white" name="field" style=" outline: 0">
                                    @foreach ($list_field as $field => $nameField)
                                        <option {{ request()->field == $field ? 'selected' : '' }}
                                            value="{{ $field }}">
                                            {{ $nameField }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="form-control" placeholder="Tìm theo trường bị vô hiệu hóa"
                                name="keyword1" value="{{ request()->keyword1 }}" style="width: 273px;">
                        </div>

                    </div>
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('user.list', ['kind' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('user.list', ['kind' => 'trash']) }}" class="text-primary">vô hiệu hóa<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                @if (Session::has('status'))
                    <div class="alert alert-success mb-0">
                        {{ Session::get('status') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger mb-0">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <form action="{{ route('user.action') }}" method="">
                    <div class="form-action form-inline py-3">
                        @can('delete_user')
                            <select class="form-control" name="act" id="">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan
                        @can('add_user')
                            <a href="{{ route('user.add') }}" class="btn btn-success">Thêm mới</a>
                        @endcan
                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th width="2%">
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col" width="20%">Họ tên</th>
                                    <th scope="col" width="26%">Email</th>
                                    <th scope="col" width="26%">Nhóm quyền</th>
                                    <th scope="col" width="9%">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count() > 0)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="listcheck[]" value="{{ $user->id }}">
                                            </td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>

                                            <td>
                                                @foreach ($user->roles as $role)
                                                    {{ '+ ' . $role->name }} <br>
                                                @endforeach
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white">không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    @endsection
