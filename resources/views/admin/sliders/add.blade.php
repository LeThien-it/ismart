@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/slider/slider.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card w-50">
            <div class="card-header font-weight-bold">
                Thêm hình ảnh quảng cáo
            </div>
            <div class="card-body">
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group pl-0">
                        <h6>
                            <label>Tiêu đề:</label>
                        </h6>
                        <input name="title" class="form-control" type="text">
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
                            <option value="0">Trang chủ</option>
                            @foreach ($catProducts as $catPro)
                                <option value="{{ $catPro->id }}">{{ $catPro->name }}</option>
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
                        <input name="position" class="form-control" type="number" min="1">
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
                                        value="0" checked>
                                    <label class="form-check-label" for="main-box">Chính</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="sub-box" class="form-check-input" type="radio" name="box"
                                        value="1">
                                    <label class="form-check-label" for="sub-box">Phụ</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-6 pl-0 ">
                            <h6>Trạng thái:</h6>
                            <div class="form-group">
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

                    <div class="form-group pl-0">
                        <h6 class="lh-24px">Hình ảnh quảng cáo:</h6>
                        <label for="upload-photo" class="btn btn-success mb-0">Tải ảnh</label>
                        <input type="file" name="image_path" class="preview_image_detail" id="upload-photo" />
                        <div class="image-detail"></div>

                        @error('image_path')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <input type="submit" class="btn btn-primary mt-3" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('backend/slider/slider.js') }}"></script>
@endsection
