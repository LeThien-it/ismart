@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            @can('add_post')
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm danh mục bài viết
                        </div>
                        <div class="card-body">
                            <form action="{{ route('post.cat.add') }}" method="POST">
                                @csrf
                                <div class="col-12 clearfix px-0">
                                    <div class="form-group col-6 float-left pl-0">
                                        <h6>
                                            <label>Tên danh mục:</label>
                                        </h6>
                                        <input class="form-control" type="text" name="name" id="name">
                                        @error('name')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6 float-right pr-0">
                                        <h6>
                                            <label>Danh mục cha:</label>
                                        </h6>

                                        <select class="form-control js-select-2" id="" name="parent_id">
                                            <option value="0">Danh mục cha</option>
                                            @foreach ($htmlOption as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group px-0">
                                    <h6>
                                        <label>Vị trí menu:</label>
                                    </h6>
                                    <input class="form-control col-3" type="number" name="position" min="0"
                                        max="10">
                                    <input type="submit" class="btn btn-primary  mt-3" value="Thêm mới">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <h5 class="m-0 ">Danh sách</h5>
                        <form class="form-inline" action="#">
                            <div class="form-group mr-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="input-group-text bg-white font-weight-custom" name="field"
                                            id="">
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
                            <a href="{{ route('post.cat.list', ['kind' => 'active']) }}" class="text-primary">Kích
                                hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ route('post.cat.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu
                                hóa<span class="text-muted">({{ $count[1] }})</span></a>
                        </div>
                        @if (Session::has('status'))
                            <div class="alert alert-success mb-0">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        @if (Session('error'))
                            <div class="alert alert-danger mb-0">
                                {{ Session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('post.cat.action') }}">
                            <div class="form-action form-inline py-3">
                                @can('delete', App\Post::class)
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
                                            <th scope="col" width="30%">Tên danh mục</th>
                                            <th scope="col" width="30%">Thuộc danh mục</th>
                                            <th scope="col" width="17%">Người tạo</th>
                                            <th scope="col" width="10%">Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($catPosts->count() > 0)
                                            @foreach ($catPosts as $catPost)
                                                @can('showCategoryPost', $catPost)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="listCheck[]"
                                                                value="{{ $catPost->id }}">
                                                        </td>
                                                        <td scope="row">
                                                            {{ $catPost->id }}
                                                        </td>
                                                        <td>{{ $catPost->name }}
                                                        </td>
                                                        @if ($catPost->parent_id == 0)
                                                            <td>Cha</td>
                                                        @else
                                                            @if ($catPost->parentCategory)
                                                                <td>{{ optional($catPost->parentCategory)->name }}</td>
                                                            @else
                                                                <td>{{ optional($catPost->getNameFromParentId())->name }}
                                                                </td>
                                                            @endif
                                                        @endif
                                                        <td>{{ optional($catPost->user)->name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($catPost->created_at)) }}</td>
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
                        {{ $catPosts->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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
