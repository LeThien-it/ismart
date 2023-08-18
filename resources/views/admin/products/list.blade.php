@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/product/list/list.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
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

                    <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary">
                </form>


            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('product.list', ['kind' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('product.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ route('product.list', ['kind' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ route('product.list', ['kind' => 'public']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ route('product.list', ['kind' => 'featured']) }}" class="text-primary">Nổi
                        bật<span class="text-muted">({{ $count[4] }})</span></a>
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

                <form action="{{ route('product.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_product')
                            <select class="form-control" id="" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan
                        @can('add_product')
                            <div class="btn-group float-right">
                                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
                                    Thêm sản phẩm
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('product.add') }}">Thêm sản phẩm chung</a></li>
                                    <li><a href="{{ route('product.variant.add') }}">Thêm sản phẩm theo biến
                                            thể</a></li>
                                </ul>
                            </div>
                        @endcan
                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="2%">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col" width="30%">Tên sản phẩm</th>
                                    @if (request()->kind == 'trash')
                                        <th scope="col">Danh mục</th>
                                    @else
                                        <th scope="col" width="13%">Danh mục</th>
                                    @endif
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Ngày tạo</th>
                                    @if (request()->kind == 'trash')
                                    @else
                                        <th scope="col" width="8%">Nổi bật</th>
                                        <th scope="col" width="10%">Trạng thái</th>
                                        @canany(['update', 'delete'], App\Product::class)
                                            <th scope="col" width="9%">Tác vụ</th>
                                        @endcanany
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->count() > 0)
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="listCheck[]" value="{{ $product->id }}">
                                            </td>
                                            <td scope="row">{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ optional($product->categorieProduct)->name }} </td>

                                            <td>{{ $product->user->name }}</td>
                                            <td>{{ date('d/m/Y', strtotime($product->created_at)) }}</td>
                                            @if (request()->kind == 'trash')
                                            @else
                                                <td>
                                                    @if ($product->featured == 0)
                                                        <a class="badge badge-secondary"
                                                            href="{{ Auth::user()->checkPermissionAccess('edit_product') ? route('product.feature', ['id' => $product->id]) : '#' }}">
                                                            None
                                                        </a>
                                                    @else
                                                        <a class="badge badge-success"
                                                            href="{{ Auth::user()->checkPermissionAccess('edit_product') ? route('product.feature', ['id' => $product->id]) : '' }}">
                                                            Nổi bật
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="{{ $product->getStatus()['class'] }}"
                                                        href="{{ Auth::user()->checkPermissionAccess('edit_product') ? route('product.status', ['id' => $product->id]) : '' }}">
                                                        {{ $product->getStatus()['name'] }}
                                                    </a>
                                                </td>
                                                @canany(['update', 'delete'], $product)
                                                    <td>
                                                        @can('update', $product)
                                                            <a href="{{ route('product.edit', ['id' => $product->id]) }}"
                                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                    class="fa fa-edit"></i>
                                                            </a>
                                                            <input type="hidden" name="url_test" value="hihi">
                                                        @endcan

                                                        @can('delete', $product)
                                                            <a href="{{ route('product.delete', ['id' => $product->id]) }}"
                                                                class="btn btn-danger btn-sm rounded-0 text-white " type="button"
                                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này')">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                @endcanany
                                            @endif

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="bg-white">
                                            Không tìm thấy bản ghi nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
