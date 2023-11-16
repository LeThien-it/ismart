@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            @can('add_attribute')
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm thuộc tính
                        </div>
                        <div class="card-body">
                            <form action="{{ route('attribute.add') }}" method="POST">
                                @csrf
                                <div class="col-12 clearfix pl-0">
                                    <div class="form-group col-6 float-left pl-0">
                                        <h6>
                                            <label>Tên thuộc tính:</label>
                                        </h6>
                                        <input type="text" class="form-control" name="name">
                                        @error('name')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6 float-right pr-0 mb-0">
                                        <h6>
                                            <label>Trạng thái:</label>
                                        </h6>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input id="pending" class="form-check-input" type="radio" name="status"
                                                    value="0" checked>
                                                <label class="form-check-label" for="pending">Chờ duyệt</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input id="public" class="form-check-input" type="radio" name="status"
                                                    value="1">
                                                <label class="form-check-label" for="public">Công khai</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <input type="submit" class="btn btn-primary mt-3" value="Thêm mới">
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <h5 class="m-0 ">Danh sách thuộc tính</h5>
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
                                    @if (request()->kind == 'trash')
                                        <input type="text" class="form-control"
                                            placeholder="Tìm theo trường bị vô hiệu hóa" name="keyword1"
                                            value="{{ request()->keyword1 }}" style="width: 273px;">
                                    @else
                                        <input type="text" class="form-control"
                                            placeholder="Tìm theo trường đang kích hoạt" name="keyword"
                                            value="{{ request()->keyword }}" style="width: 273px;">
                                    @endif
                                </div>

                            </div>
                            <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary">
                        </form>


                    </div>
                    <div class="card-body">
                        <div class="analytic">
                            <a href="{{ route('attribute.list', ['kind' => 'active']) }}" class="text-primary">Kích
                                hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ route('attribute.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu
                                hóa<span class="text-muted">({{ $count[1] }})</span></a>
                        </div>

                        @if (Session::has('status'))
                            <div class="alert alert-success mb-0">
                                {{ Session::get('status') }}
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-danger mb-0">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <form action="{{ route('attribute.action') }}">
                            <div class="form-action form-inline py-3">
                                @can('delete', App\Attribute::class)
                                    <div class="mb-3">
                                        <select class="form-control mr-1" id="" name="act">
                                            <option value="">Chọn tác vụ</option>
                                            @foreach ($list_act as $act => $act_content)
                                                <option value="{{ $act }}">{{ $act_content }}</option>
                                            @endforeach
                                        </select>

                                        <input type="submit" value="Áp dụng" class="btn btn-primary">
                                    </div>
                                @endcan
                                <table class="table table-striped table-bordered table-checkall">
                                    <thead>
                                        <tr>
                                            <th width="2%">
                                                <input type="checkbox" name="checkall">
                                            </th>
                                            <th scope="col" width="5%">ID</th>
                                            <th scope="col">Tên thuộc tính</th>
                                            <th scope="col">Người tạo</th>
                                            <th scope="col">Ngày tạo</th>
                                            @if (request()->kind == 'trash')
                                            @else
                                                <th scope="col" width="10%">Trạng thái</th>
                                                @canany(['update', 'delete'], App\Attribute::class)
                                                    <th scope="col" width="9%">Thao tác</th>
                                                @endcanany
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($attributes->count() > 0)
                                            @foreach ($attributes as $attribute)
                                                @can('view', $attribute)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="listcheck[]"
                                                                value="{{ $attribute->id }}">
                                                        </td>
                                                        <td scope="row">{{ $attribute->id }}</td>
                                                        <td>{{ $attribute->name }}</td>
                                                        <td>{{ $attribute->user->name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($attribute->created_at)) }}</td>

                                                        @if (request()->kind == 'trash')
                                                        @else
                                                            <td>
                                                                <a class="{{ $attribute->getStatus()['class'] }}"
                                                                    href="{{ Auth::user()->checkPermissionAccess('edit_attribute') ? route('attribute.status', ['id' => $attribute->id]) : '' }}">
                                                                    {{ $attribute->getStatus()['name'] }}
                                                                </a>
                                                            </td>
                                                            @canany(['update', 'delete'], $attribute)
                                                                <td>
                                                                    @can('update', $attribute)
                                                                        <a href="{{ route('attribute.edit', ['id' => $attribute->id]) }}"
                                                                            class="btn btn-success btn-sm rounded-0 text-white"
                                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                                            title="Edit"><i class="fa fa-edit"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete', $attribute)
                                                                        <a href="{{ route('attribute.delete', ['id' => $attribute->id]) }}"
                                                                            class="btn btn-danger btn-sm rounded-0 text-white"
                                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                                            onclick="return confirm('bạn có chắc muốn xóa thuộc tính này không ? (Nếu xóa thuộc tính này các giá trị của thuộc tính cũng bị xóa đi)')"
                                                                            title="Delete">
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
                        {{ $attributes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
