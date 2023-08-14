@extends('layouts.admin')


@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhật danh mục bài viết
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.cat.update', ['id' => $catPost->id]) }}" method="POST">
                            @csrf
                            <div class="form-group pl-0">
                                <h6>
                                    <label for="name">Tên danh mục:</label>
                                </h6>
                                <input class="form-control" type="text" name="name" value="{{ $catPost->name }}"
                                    id="name">
                                @error('name')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group pl-0">
                                <h6>
                                    <label for="">Danh mục cha:</label>
                                </h6>
                                <select class="form-control js-select-2" id="" name="parent_id">
                                    <option value="0">Danh mục cha</option>
                                    @foreach ($htmlOption as $k => $v)
                                        @if ($catPost->parent_id == $k)
                                            <option selected value="{{ $k }}">{{ $v }}</option>
                                        @else
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-5 pl-0">
                                <h6>
                                    <label for="">Vị trí menu:</label>
                                </h6>
                                <input class="form-control" type="number" name="position" id="" min="0" max="10"
                                    value="{{ $catPost->position }}">
                            </div>
                            <input type="submit" name="btn_add" class="btn btn-primary mt-3" value="Cập nhật">


                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/categoryPost/list/list.js') }}"></script>
@endsection

