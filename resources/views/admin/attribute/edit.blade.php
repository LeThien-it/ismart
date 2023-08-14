@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    @if (Session::has('status'))
                        <div class="alert alert-success">
                            {{ Session::get('status') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Cập nhật thuộc tính
                    </div>
                    <div class="card-body">
                        <form action="{{ route('attribute.update', ['id' => $attribute->id]) }}" method="POST">
                            @csrf
                            <div class="form-group col-6 pl-0">
                                <label for="">Tên thuộc tính:</label>
                                <input type="text" class="form-control" name="name" value="{{ $attribute->name }}">
                                @error('name')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Trạng thái:</label>
                                <div class="form-group mt-2">
                                    <div class="form-check form-check-inline">
                                        <input id="pending" class="form-check-input" type="radio" name="status" value="0"
                                            {{ $attribute->status == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pending">Chờ duyệt</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="public" class="form-check-input" type="radio" name="status" value="1"
                                            {{ $attribute->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="public">Công khai</label>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Cập nhật">
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
