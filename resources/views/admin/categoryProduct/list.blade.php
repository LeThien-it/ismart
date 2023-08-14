@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            @can('add_product')
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm danh mục sản phẩm
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.cat.add') }}" method="POST">
                                @csrf
                                <div class="col-12 clearfix px-0">
                                    <div class="form-group col-6 float-left pl-0">
                                        <h6>
                                            <label for="name">Tên danh mục:</label>
                                        </h6>
                                        <input class="form-control" type="text" name="name" id="name">
                                        @error('name')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6 float-right pr-0">
                                        <h6>
                                            <label for="">Danh mục cha:</label>
                                        </h6>
                                        <select class="form-control js-select-2" id="" name="parent_id">
                                            <option value="0">Danh mục cha</option>
                                            @foreach ($htmlOption as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-12 clearfix px-0">
                                    <div class="form-group col-6 float-left pl-0">
                                        <h6>
                                            <label>Icon danh mục:</label>
                                        </h6>

                                        <input class="form-control" type="text" name="class">
                                        @error('class')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6 float-right pr-0">
                                        <h6>
                                            <label>Vị trí menu:</label>
                                        </h6>

                                        <input class="form-control" type="number" name="position" min="0"
                                            max="10">
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
                        <h5 class="m-0 ">Danh sách</h5>
                        <form class="form-inline" action="#">
                            <div class="form-group mr-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="input-group-text bg-white font-weight-custom" name="field"
                                            id="">
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
                            <a href="{{ route('product.cat.list', ['kind' => 'active']) }}" class="text-primary">Kích
                                hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ route('product.cat.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu
                                hóa<span class="text-muted">({{ $count[1] }})</span></a>
                        </div>

                        @if (Session::has('status'))
                            <div class="alert alert-success mb-0">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        @if (Session('error'))
                            <div class="alert alert-danger mb-0">
                                {{ Session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('product.cat.action') }}">
                            <div class="form-action form-inline py-3">
                                @can('delete', App\Product::class)
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
                                            <th scope="col" width="2%">ID</th>
                                            <th scope="col" width="30%">Tên danh mục</th>
                                            <th scope="col" width="30%">Thuộc danh mục</th>
                                            <th scope="col" width="17%">Người tạo</th>
                                            <th scope="col" width="10%">Ngày tạo</th>
                                            @if (request()->kind == 'trash')
                                            @else
                                                @canany(['update', 'delete'], App\Product::class)
                                                    <th scope="col" width="9%">Thao tác</th>
                                                @endcanany
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($catProducts->count() > 0)
                                            @foreach ($catProducts as $catProduct)
                                                @can('showCategoryProduct', $catProduct)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="listCheck[]"
                                                                value="{{ $catProduct->id }}">
                                                        </td>
                                                        <td scope="row">
                                                            {{ $catProduct->id }}
                                                        </td>
                                                        <td>{{ $catProduct->name }}
                                                        </td>
                                                        @if ($catProduct->parent_id == 0)
                                                            <td>Cha</td>
                                                        @else
                                                            @if ($catProduct->parentCategory)
                                                                <td>{{ optional($catProduct->parentCategory)->name }}</td>
                                                            @else
                                                                <td>{{ optional($catProduct->getNameFromParentId())->name }}
                                                                </td>
                                                            @endif
                                                        @endif
                                                        <td>{{ optional($catProduct->user)->name }}</td>

                                                        <td>{{ date('d/m/Y', strtotime($catProduct->created_at)) }}
                                                        </td>
                                                        @if (request()->kind == 'trash')
                                                        @else
                                                            @canany(['update', 'delete'], App\Product::class)
                                                                <td>
                                                                    @can('update', App\Product::class)
                                                                        <a href="{{ route('product.cat.edit', ['id' => $catProduct->id]) }}"
                                                                            class="btn btn-success btn-sm rounded-0 text-white"
                                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                                            title="Edit"><i class="fa fa-edit"></i></a>
                                                                    @endcan

                                                                    @can('delete', App\Product::class)
                                                                        <a href="{{ route('product.cat.delete', ['id' => $catProduct->id]) }}"
                                                                            class="btn btn-danger btn-sm rounded-0 text-white "
                                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                                            title="Delete"
                                                                            onclick="return confirm('bạn có chắc muốn xóa danh mục này')">
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



                        {{ $catProducts->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/categoryProduct/list/list.js') }}"></script>
@endsection
