@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
                <form class="form-inline" action="#">
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="input-group-text bg-white font-weight-custom" name="field" id="">
                                    @foreach ($list_field as $field => $nameField)
                                        <option {{ request()->field == $field ? 'selected' : '' }}
                                            value="{{ $field }}">
                                            {{ $nameField }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if (request()->kind == 'trash')
                                <input type="text" class="form-control" placeholder="Tìm theo trường bị vô hiệu hóa"
                                    name="keyword1" value="{{ request()->keyword1 }}" style="width: 273px;">
                            @else
                                <input type="text" class="form-control" placeholder="Tìm theo trường đang kích hoạt"
                                    name="keyword" value="{{ request()->keyword }}" style="width: 273px;">
                            @endif
                        </div>

                    </div>

                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>

            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('page.list', ['kind' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('page.list', ['kind' => 'trash']) }}" class="text-primary">Vô
                        hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ route('page.list', ['kind' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ route('page.list', ['kind' => 'public']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[3] }})</span></a>
                </div>

                @if (Session('status'))
                    <div class="alert alert-success mb-0">
                        {{ Session('status') }}
                    </div>
                @endif
                @if (Session('error'))
                    <div class="alert alert-danger mb-0">
                        {{ Session('error') }}
                    </div>
                @endif

                <form action="{{ route('page.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_page')
                            <select class="form-control" id="" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan

                        @can('add_page')
                            <a href="{{ route('page.add') }}" class="btn btn-success">Thêm mới</a>
                        @endcan
                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="2%">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col" width="3%">ID</th>
                                    <th scope="col" width="33%">Tên trang</th>
                                    <th scope="col" width="33%">Người tạo</th>
                                    <th scope="col" width="10%">Ngày tạo</th>
                                    @if (request()->kind == 'trash')
                                    @else
                                        <th scope="col" width="10%">Trạng thái</th>
                                        @canany(['update', 'delete'], App\Page::class)
                                            <th scope="col" width="9%">Tác vụ</th>
                                        @endcanany
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pages->count() > 0)
                                    @foreach ($pages as $page)
                                        @can('view', $page)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="listCheck[]" value="{{ $page->id }}">
                                                </td>
                                                <td scope="row">{{ $page->id }}</td>
                                                <td>{{ $page->name }}</td>
                                                <td>
                                                    @if ($page->user)
                                                        {{ $page->user->name }}
                                                    @else
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($page->created_at)) }}</td>
                                                @if (request()->kind == 'trash')
                                                @else
                                                    <td>
                                                        <a class="{{ $page->getStatus()['class'] }}"
                                                            href="{{ Auth::user()->checkPermissionAccess('edit_page') ? route('page.status', ['id' => $page->id]) : '#' }}">
                                                            {{ $page->getStatus()['name'] }}
                                                        </a>
                                                    </td>

                                                    @canany(['update', 'delete'], $page)
                                                        <td>
                                                            @can('update', $page)
                                                                <a href="{{ route('page.edit', ['id' => $page->id]) }}"
                                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                        class="fa fa-edit"></i></a>
                                                            @endcan
                                                            @can('delete', $page)
                                                                <a href="{{ route('page.delete', ['id' => $page->id]) }}"
                                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                                    onclick="return confirm('Bạn có chắc muốn xóa trang này không')">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                    @endcanany
                                                @endif

                                            </tr>
                                        @endcan
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif



                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $pages->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
