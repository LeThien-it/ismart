@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/product/add/add.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>

            <div class="card-body">
                <form action="{{ route('product.variant.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="text-uppercase"><span class="border-custom ">Thông tin sản phẩm</span></h5>
                    <div class="form-group mt-3">
                        <h6>Tên sản phẩm:</h6>
                        <select name="product_id" class="form-control js-select-2">
                            <option value="">Chọn tên sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <h6>Ảnh đại diện:</h6>
                        <label for="upload-photo" class="btn btn-success">Tải ảnh</label>
                        <input type="file" name="feature_image_path" class="preview_image_detail" id="upload-photo" />
                        <span></span>
                        <div class="image-detail">

                        </div>
                        @error('feature_image_path')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <h6>Ảnh chi tiết:</h6>
                        <label for="upload-detail-image" class="btn btn-success">Tải ảnh</label>
                        <span class="numFiles"></span>
                        <input type="file" class="preview_image_multiple" id="upload-detail-image" name="image_path[]"
                            multiple />
                        <div class="row image_detail_wrapper ml-0">

                        </div>
                        @error('image_path')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        @error('image_path.*')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group form-row">
                        <div class="col-6">
                            <h6><label for="price">Giá sản phẩm:</label></h6>
                            <input class="form-control" type="text" name="price" id="price"
                                value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <h6><label for="price_old">Giá cũ:</label></h6>
                            <input class="form-control" type="text" name="price_old" id="price_old"
                                value="{{ old('price_old') }}">
                            @error('price_old')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group form-row">
                        <div class="col-6">
                            <h6><label for="quantity">Số lượng hàng:</label></h6>
                            <input class="form-control" type="text" name="quantity" id="quantity"
                                value="{{ old('quantity') }}">
                            @error('quantity')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <h6><label for="discount">Giảm giá <span class="text-danger">(Đơn vị %)</span>:</label></h6>
                            <input class="form-control" type="text" name="discount" id="discount"
                                value="{{ old('discount') }}">
                            @error('discount')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <h6>Ưu tiên hiển thị:</h6>

                                <div class="form-check">
                                    <input class="form-check-input" name="display_style" type="radio" value="0"
                                        id="display_sub" checked>
                                    <label class="form-check-label" for="display_sub">
                                        Trang chi tiết sản phẩm
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="display_style" type="radio" value="1"
                                        id="display_main">
                                    <label class="form-check-label" for="display_main">
                                        Trang danh mục sản phẩm
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <h6>Ưu tiên hiển thị tìm kiếm:</h6>

                                <div class="form-check">
                                    <input class="form-check-input" name="show_search" type="radio" value="0"
                                        id="hide_search" checked>
                                    <label class="form-check-label" for="hide_search">
                                        Ẩn
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="show_search" type="radio" value="1"
                                        id="show_search">
                                    <label class="form-check-label" for="show_search">
                                        Hiển thị
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-uppercase"><span class="border-custom">Thuộc tính sản phẩm</span></h5>
                    <div class="form-group mt-3">
                        <div class="form-row">
                            @foreach ($attributes as $attribute)
                                <div class="col-sm-3 pr-30px">
                                    <h6 class="border-bottom"><span>{{ $attribute->name }}</span></h6>
                                    @foreach ($attribute->values as $attributeValue)
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="attribute_value_id[]"
                                                    id="attribute{{ $attributeValue->id }}" type="checkbox"
                                                    value="{{ $attributeValue->id }}">
                                                <label
                                                    for="attribute{{ $attributeValue->id }}">{{ $attributeValue->value }}</label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>
                        @error('attribute_value_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/g8rgxy2yvvlw1uv1if15j5qs6y25dmlfse7j03mkzsk2ibz8/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('backend/admin-template/js/tiny.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/product/add/add.js') }}"></script>
@endsection
