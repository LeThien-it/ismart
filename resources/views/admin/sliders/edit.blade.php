@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/slider/slider.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card w-50">
                    <div class="card-header font-weight-bold">
                        Cập nhật hình ảnh quảng cáo
                    </div>
                    <div class="card-body">
                        <form action="{{ route('slider.update', ['id' => $slider->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group pl-0">
                                <h6>
                                    <label>Tiêu đề:</label>
                                </h6>
                                <input name="title" class="form-control" type="text" value="{{ $slider->title }}">
                                @error('title')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group pl-0">
                                <h6>
                                    <label>Danh mục:</label>
                                </h6>
                                <select class="form-control" name="cat_pro_id">
                                    <option value="">Chọn</option>
                                    <option value="0" {{ $slider->cat_pro_id == 0 ? 'selected' : '' }}>Trang chủ
                                    </option>
                                    @foreach ($catProducts as $catProduct)
                                        <option {{ $slider->cat_pro_id == $catProduct->id ? 'selected' : '' }} value="{{ $catProduct->id }}">{{ $catProduct->name }}</option>
                                    @endforeach
                                </select>
                                @error('cat_pro_id')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group pl-0">
                                <h6>
                                    <label>Vị trí hình ảnh:</label>
                                </h6>
                                <input name="position" class="form-control" type="number" min="1"
                                    value="{{ $slider->position }}">
                                @error('position')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="form-group pl-0">
                                    <h6>Hình ảnh hiển thị:</h6>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input id="main-box" class="form-check-input" type="radio" name="box"
                                                value="0" {{ $slider->box == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="main-box">Chính</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="sub-box" class="form-check-input" type="radio" name="box"
                                                value="1" {{ $slider->box == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sub-box">Phụ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6 pl-0 ">
                                    <h6>Trạng thái:</h6>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input id="pending" class="form-check-input" type="radio" name="status"
                                                value="0" {{ $slider->status == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pending">Chờ duyệt</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="public" class="form-check-input" type="radio" name="status"
                                                value="1" {{ $slider->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="public">Công khai</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group pl-0">
                                <h6 class="lh-24px">Hình ảnh quảng cáo:</h6>
                                <label for="upload-photo" class="btn btn-success mb-0">Tải ảnh</label>
                                <input type="file" name="image_path" class="preview_image_detail" id="upload-photo" />
                                <div class="image-detail">
                                    <div class="card col-md-12 mr-2 mt-3">
                                        <img class="card-img-top image_detail_product"
                                            src="{{ asset($slider->image_path) }}" alt="">
                                    </div>
                                </div>

                                @error('image_path')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary" value="Cập nhật">
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection


@section('js')
    <script src="{{ asset('backend/slider/slider.js') }}"></script>
@endsection
