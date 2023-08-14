@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/product/add/add.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>

            <div class="card-body">
                <form action="{{ route('product.variant.update', ['id' => $variant->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5 class="text-uppercase"><span class="border-custom ">Thông tin sản phẩm</span></h5>
                    <div class="form-group mt-3">
                        <h6>Tên sản phẩm:</h6>
                        <select name="product_id" class="form-control js-select-2">
                            @foreach ($products as $p)
                                @if ($variant->product_id == $p->id)
                                    <option selected value="{{ $p->id }}">{{ $p->name }}</option>
                                @else
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endif
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
                            <div class="card col-md-3 mr-2">
                                <img class="card-img-top image_detail_product"
                                    src="{{ asset($variant->feature_image_path) }}" alt="">
                            </div>
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
                        <input type="file" name="image_path[]" multiple class="preview_image_multiple"
                            id="upload-detail-image" />
                        <div class="row image_detail_wrapper ml-0">
                            @foreach ($variant->images as $src)
                                <div class="card col-md-3 mr-2">
                                    <img class="card-img-top image_detail_product" src="{{ asset($src->image_path) }}"
                                        alt="">
                                </div>
                            @endforeach

                        </div>
                        @error('image_path')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror

                    </div>
                    <div class="form-group form-row">
                        <div class="col-6">
                            <h6><label for="price">Giá sản phẩm:</label></h6>
                            <input class="form-control" type="text" name="price" id="price"
                                value="{{ optional($variant)->price }}">
                            @error('price')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <h6><label for="price_old">Giá cũ:</label></h6>
                            <input class="form-control" type="text" name="price_old" id="price_old"
                                value="{{ optional($variant)->price_old }}">
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
                                value="{{ optional($variant)->quantity }}">
                            @error('quantity')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <h6><label for="discount">Giảm giá <span class="text-danger">(Đơn vị %)</span>:</label></h6>
                            <input class="form-control" type="text" name="discount" id="discount"
                                value="{{ optional($variant)->discount }}">
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
                                        id="display_sub" {{ $variant->display_style == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="display_sub">
                                        Trang chi tiết sản phẩm 

                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="display_style" type="radio" value="1"
                                        id="display_main" {{ $variant->display_style == 1 ? 'checked' : '' }}>
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
                                        id="hide_search" {{ $variant->show_search == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hide_search">
                                        Ẩn
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="show_search" type="radio" value="1"
                                        id="show_search" {{ $variant->show_search == 1 ? 'checked' : '' }}>
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
                                                    value="{{ $attributeValue->id }}"
                                                    {{ in_array($attributeValue->id, $check) ? 'checked' : '' }}>
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


                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/product/add/add.js') }}"></script>
@endsection
