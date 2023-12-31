@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/attribute/list/list.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            @can('add_attribute')
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm giá trị thuộc tính
                        </div>
                        <div class="card-body">
                            <form action="{{ route('attribute.value.add') }}" method="POST">
                                @csrf
                                <div class="col-12 clearfix px-0">
                                    <div class="form-group col-6 float-left pl-0">
                                        <h6>
                                            <label>Tên thuộc tính:</label>
                                        </h6>
                                        <select class="form-control" name="attribute_id">
                                            <option value="">Chọn</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
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
                                        <input class="form-control" type="text" name="value" value="{{ old('value') }}">
                                        @error('value')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 px-0">
                                    <input type="submit" class="btn btn-primary mt-3" value="Thêm mới">
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <h5 class="m-0 ">Danh sách giá trị thuộc tính</h5>
                        <form class="form-inline" action="#">
                            <div class="form-group mr-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="input-group-text bg-white" name="field" style=" outline: 0">
                                            @foreach ($list_field as $field => $nameField)
                                                <option {{ request()->field == $field ? 'selected' : '' }}
                                                    value="{{ $field }}">
                                                    {{ $nameField }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Tìm theo trường bị vô hiệu hóa"
                                        name="keyword1" value="{{ request()->keyword1 }}" style="width: 273px;">
                                </div>
                            </div>
                            <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="analytic">
                            <a href="{{ route('attribute.value.list', ['kind' => 'active']) }}" class="text-primary">Kích
                                hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ route('attribute.value.list', ['kind' => 'trash']) }}" class="text-primary">Vô
                                hiệu
                                hóa<span class="text-muted">({{ $count[1] }})</span></a>
                        </div>
                        @if (Session::has('status'))
                            <div class="alert alert-success mb-0">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger mb-0">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <form action="{{ route('attribute.value.action') }}">
                            <div class="form-action form-inline py-3">
                                @can('delete_attribute')
                                    <div class="mb-3">
                                        <select class="form-control mr-1" id="" name="act">
                                            <option value="">Chọn tác vụ</option>
                                            @foreach ($list_act as $act => $act_content)
                                                <option value="{{ $act }}">{{ $act_content }}</option>
                                            @endforeach
                                        </select>
                                        <input type="submit" value="Áp dụng" class="btn btn-primary">
                                    </div>
                                @endcan
                                <table class="table table-striped table-bordered table-checkall">
                                    <thead>
                                        <tr>
                                            <th width="2%">
                                                <input type="checkbox" name="checkall">
                                            </th>
                                            <th scope="col" width="2%">ID</th>
                                            <th scope="col" width="34%">Tên thuộc tính</th>
                                            <th scope="col" width="34%">Giá trị</th>
                                            <th scope="col" width="12%">Người tạo</th>
                                            <th scope="col" width="6%">Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($attributeValues->count() > 0)
                                            @foreach ($attributeValues as $attributeValue)
                                                @can('showAttributeValue', [$attributeValue->attribute, $attributeValue])
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="listcheck[]"
                                                                value="{{ $attributeValue->id }}">
                                                        </td>
                                                        <td scope="row">{{ $attributeValue->id }}</td>
                                                        <td>{{ optional($attributeValue->attribute)->name }} </td>
                                                        <td>{{ $attributeValue->value }}</td>
                                                        <td> {{ $attributeValue->attribute->user->name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($attributeValue->created_at)) }}
                                                        </td>
                                                    </tr>
                                                @endcan
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="bg-white">Không tìm thấy bản ghi nào</td>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>

                        </form>


                        {{ $attributeValues->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
