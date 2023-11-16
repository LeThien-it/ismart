@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
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
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>

            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('post.list', ['kind' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('post.list', ['kind' => 'trash']) }}" class="text-primary">Vô
                        hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ route('post.list', ['kind' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ route('post.list', ['kind' => 'public']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[3] }})</span></a>
                </div>
                @if (Session('status'))
                    <div class="alert alert-success mb-0">
                        {{ Session('status') }}
                    </div>
                @endif
                @if (Session('error'))
                    <div class="alert alert-danger mb-0">
                        {{ Session('error') }}
                    </div>
                @endif
                <form action="{{ route('post.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_post')
                            <select class="form-control" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan

                        @can('add_post')
                            <a href="{{ route('post.add') }}" class="btn btn-success">Thêm mới</a>
                        @endcan

                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="2%">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col" width="17%">Ảnh</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col" width="12%">Danh mục</th>
                                    <th scope="col" width="15%">Người tạo</th>
                                    <th scope="col" width="11%">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($posts->count() > 0)
                                    @foreach ($posts as $post)
                                        @can('view', $post)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="listCheck[]" value="{{ $post->id }}">
                                                </td>
                                                <td scope="row">{{ $post->id }}</td>
                                                <td><img class="img-thumbnail" src="{{ asset($post->post_image_path) }}"
                                                        alt="">
                                                </td>
                                                <td>{{ $post->title }}</td>
                                                <td>
                                                    @if ($post->categoryPost)
                                                        {{ $post->categoryPost->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($post->user)
                                                        {{ $post->user->name }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($post->created_at)) }}</td>
                                            </tr>
                                        @endcan
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="bg-white">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $posts->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
