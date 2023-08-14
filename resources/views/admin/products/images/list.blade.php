@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/product/add/add.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            @can('add_product')
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm hình ảnh
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.image.add', ['id' => $id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <h6>Ảnh chi tiết:</h6>
                                    <label for="upload-detail-image" class="btn btn-success">Tải ảnh</label>
                                    <span class="numFiles"></span>
                                    <input type="file" name="image_path[]" multiple class="preview_image_multiple"
                                        id="upload-detail-image" />
                                    <div class="row image_detail_wrapper ml-0">

                                    </div>
                                    @error('image_path')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror

                                </div>
                                <input type="submit" name="btn_add" class="btn btn-primary mt-3" value="Thêm mới">
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <h5 class="m-0 ">Danh sách ảnh chi tiết</h5>
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
                            <a href="{{ route('product.image.list', ['id' => $id, 'kind' => 'active']) }}"
                                class="text-primary">Kích
                                hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ route('product.image.list', ['id' => $id, 'kind' => 'trash']) }}"
                                class="text-primary">Vô
                                hiệu
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
                        <form action="{{ route('product.image.action', ['id' => $id]) }}">
                            <div class="form-action form-inline py-3">
                                @can('delete_product')
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
                                            <th scope="col" width="40%">Tên ảnh</th>
                                            <th scope="col" width="11%">Hình ảnh</th>
                                            <th scope="col" width="8%">Ngày tạo</th>
                                            @if (request()->kind == 'trash')
                                            @else
                                                @can('delete_product')
                                                    <th scope="col" width="7%">Thao tác</th>
                                                @endcan
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($images->count() > 0)
                                            @foreach ($images as $image)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="listCheck[]"
                                                            value="{{ $image->id }}">
                                                    </td>
                                                    <td scope="row">{{ $image->id }}</td>
                                                    <td>{{ $image->image_name }}</td>
                                                    <td>
                                                        <img class="img-thumbnail"src="{{ asset($image->image_path) }}"
                                                            alt="">
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($image->created_at)) }}</td>

                                                    @if (request()->kind == 'trash')
                                                    @else
                                                        @can('delete_product')
                                                            <td class="text-center">
                                                                <a href="{{ route('product.image.delete', ['id' => $image->id]) }}"
                                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                                    onclick="return confirm('bạn có chắc muốn xóa bản ghi này không')"
                                                                    title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>

                                                            </td>
                                                        @endcan
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="bg-white">Không tìm thấy bản ghi nào</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </form>


                        {{ $images->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('backend/product/add/add.js') }}"></script>
@endsection
