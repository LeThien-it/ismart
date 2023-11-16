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
                        <form action="{{ route('attribute.value.update', ['id' => $attributeValue->id]) }}" method="POST">
                            @csrf
                            <div class="col-12 clearfix p-0">
                                <div class="form-group col-6 float-left pl-0">
                                    <h6>
                                        <label>Tên thuộc tính:</label>
                                    </h6>
                                    <select class="form-control" name="attribute_id">
                                        <option value="">Chọn</option>
                                        @foreach ($attributes as $attribute)
                                            @if ($attribute->id == $attributeValue->attribute_id)
                                                <option selected value="{{ $attribute->id }}">{{ $attribute->name }}
                                                </option>
                                            @else
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('attribute_id')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6 float-right pr-0">
                                    <h6>
                                        <label>Giá trị:</label>
                                    </h6>
                                    <input class="form-control" type="text" name="value" value="{{ $attributeValue->value }}">
                                    @error('value')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 p-0">
                                <input type="submit" class="btn btn-primary mt-3" value="Cập nhật">
                            </div>



                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
