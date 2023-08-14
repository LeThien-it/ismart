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
                        Cập nhật danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.cat.update', ['id' => $catProduct->id]) }}" method="POST">
                            @csrf
                            <div class="col-12 clearfix px-0">
                                <div class="form-group col-6 float-left pl-0">
                                    <h6>
                                        <label for="name">Tên danh mục:</label>
                                    </h6>

                                    <input class="form-control" type="text" name="name"
                                        value="{{ $catProduct->name }}" id="name">
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

                                    <select class="form-control js-select-2" name="parent_id">
                                        <option value="0">Danh mục cha</option>
                                        @foreach ($htmlOption as $k => $v)
                                            @if ($catProduct->parent_id == $k)
                                                <option selected value="{{ $k }}">{{ $v }}</option>
                                            @else
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-12 clearfix px-0">
                                <div class="form-group col-6 float-left pl-0">
                                    <h6>
                                        <label>Icon danh mục:</label>
                                    </h6>

                                    <input class="form-control" type="text" name="class"
                                        value="{{ $catProduct->class }}">
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

                                    <input class="form-control" type="number" name="position" min="0" max="10"
                                        value="{{ $catProduct->position }}">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mt-3" value="Cập nhật">

                        </form>
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
