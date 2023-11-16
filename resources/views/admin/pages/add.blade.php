@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/page/add/add.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm trang
            </div>
            <div class="card-body">
                <form action="{{ route('page.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h6>
                            <label>Tên trang:</label>
                        </h6>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>
                            <label>Nội dung trang:</label>
                        </h6>
                        <textarea name="content" class="form-control content-tiny" cols="30" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>Trạng thái:</h6>

                        <div class="form-check">
                            <input class="form-check-input" name="status" type="radio" value="0" id="status"
                                checked>
                            <label class="form-check-label" for="status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="status" type="radio" value="1" id="status1">
                            <label class="form-check-label" for="status1">
                                Công khai
                            </label>
                        </div>
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
@endsection
