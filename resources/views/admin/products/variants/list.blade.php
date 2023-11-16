@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/product/list/list.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0">Danh sách sản phẩm</h5>
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
                    <a href="{{ route('product.variant.list', ['kind' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('product.variant.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
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
                <form action="{{ route('product.variant.action') }}">
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
                            <div class="btn-group">
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

                        <table class="table table-striped table-bordered table-checkall fs-variant mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="2%">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col" width="25%">Tên sản phẩm</th>
                                    <th scope="col" width="19%">Thông tin chung</th>
                                    <th scope="col" width="13%">Ảnh đại diện</th>
                                    <th scope="col" width="11%">Ảnh chi tiết</th>
                                    <th scope="col" width="9%">Ngày tạo</th>
                                    @if (request()->kind == 'trash')
                                    @else
                                        @canany(['update', 'delete'], App\Product::class)
                                            <th scope="col" width="9%">Tác vụ</th>
                                        @endcanany
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($variants->count() > 0)
                                    @foreach ($variants as $variant)
                                        @can('view', $variant->product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="listCheck[]" value="{{ $variant->id }}">
                                                </td>
                                                <td scope="row">{{ $variant->id }}</td>
                                                <td><a
                                                        href="{{ route('product.variant.edit', $variant->id) }}">{{ $variant->product->name }}</a>
                                                </td>
                                                <td>

                                                    <p>Giá: {{ number_format($variant->price, 0, '.', '.') }}VNĐ</p>
                                                    @if ($variant->price_old)
                                                        <p>Giá cũ: {{ number_format($variant->price_old, 0, '.', '.') }}VNĐ
                                                        </p>
                                                    @endif
                                                    <p>Số lượng hàng: {{ $variant->quantity }}</p>
                                                    @foreach ($variant->attributeValues as $item)
                                                        <p>{{ $item->attribute->name }} : <span>{{ $item->value }}</span>
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td><img class="img-thumbnail" src="{{ asset($variant->feature_image_path) }}"
                                                        alt=""> </td>
                                                <td class="text-center">
                                                    <a href="{{ route('product.image.list', ['id' => $variant->id]) }}"
                                                        class="btn btn-outline-info" data-toggle="tooltip"
                                                        title="Ảnh chi tiết"><i class="fas fa-images"></i>
                                                    </a>
                                                </td>

                                                <td>{{ date('d/m/Y', strtotime($variant->created_at)) }}</td>
                                                @if (request()->kind == 'trash')
                                                @else
                                                    @canany(['update', 'delete'], $variant->product)
                                                        <td>
                                                            @can('update', $variant->product)
                                                                <a href="{{ route('product.variant.edit', ['id' => $variant->id]) }}"
                                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                        class="fa fa-edit"></i></a>
                                                            @endcan

                                                            @can('delete', $variant->product)
                                                                <a href="{{ route('product.variant.delete', ['id' => $variant->id]) }}"
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
                                        @endcan
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="bg-white">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif



                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $variants->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
