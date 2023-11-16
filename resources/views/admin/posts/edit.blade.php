@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/post/post.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h6>
                            <label>Tiêu đề bài viết:</label>
                        </h6>
                        <input class="form-control" type="text" name="title" value="{{ $post->title }}">

                        @error('title')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="upload-photo" class="btn btn-success">Tải ảnh lên</label>
                        <input type="file" name="post_image_path" class="preview_image_detail" id="upload-photo" />
                        <div class="image-detail">
                            <div class="card col-md-3 mr-2">
                                <img class="card-img-top image_detail_product" id="output"
                                    src="{{ asset($post->post_image_path) }}" alt="">
                            </div>
                            @error('post_image_path')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h6>
                            <label>Mô tả ngắn:</label>
                        </h6>
                        <textarea name="desc" class="form-control content-tiny" cols="30" rows="10">{{ $post->desc }}</textarea>
                        @error('desc')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>
                            <label>Nội dung bài viết:</label>
                        </h6>
                        <textarea name="content" class="form-control content-tiny" cols="30" rows="15">{{ $post->content }}</textarea>
                        @error('content')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>
                            <label>Danh mục:</label>
                        </h6>
                        <select class="form-control js-select-2" name="category_id">
                            <option>Chọn danh mục</option>
                            @foreach ($htmlOption as $k => $v)
                                @if ($post->category_id == $k)
                                    <option selected value="{{ $k }}">{{ $v }}</option>
                                @else
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>Trạng thái:</h6>

                        <div class="form-check">
                            <input class="form-check-input" name="status" type="radio" value="0" id="status"
                                {{ $post->status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="status" type="radio" value="1" id="status1"
                                {{ $post->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status1">
                                Công khai
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    <script src="{{ asset('backend/post/post.js') }}"></script>
@endsection
