@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/slider/slider.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách ảnh slider</h5>
                <form class="form-inline" action="#">
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="input-group-text bg-white font-weight-custom" name="field" id="">
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
                    <a href="{{ route('slider.list', ['kind' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('slider.list', ['kind' => 'trash']) }}" class="text-primary">Vô
                        hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ route('slider.list', ['kind' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ route('slider.list', ['kind' => 'public']) }}" class="text-primary">Công
                        khai<span class="text-muted">({{ $count[3] }})</span></a>
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
                <form action="{{ route('slider.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_slider')
                            <select class="form-control" id="" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan

                        @can('add_slider')
                            <a href="{{ route('slider.add') }}" class="btn btn-success">Thêm mới</a>
                        @endcan

                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th width="2%">
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col">Tên ảnh</th>
                                    <th scope="col" width="20%">Hình ảnh</th>
                                    <th scope="col" width="20%">Thông tin chung</th>
                                    <th scope="col" width="11%">Người tạo</th>
                                    <th scope="col" width="10%">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sliders->count() > 0)
                                    @foreach ($sliders as $slider)
                                        @can('view', $slider)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="listCheck[]" value="{{ $slider->id }}">
                                                </td>
                                                <td scope="row">{{ $slider->id }}</td>
                                                <td>{{ $slider->image_name }}</td>
                                                <td>
                                                    <img class="img-thumbnail" src="{{ asset($slider->image_path) }}"
                                                        alt="">
                                                </td>
                                                <td>
                                                    <p>Vị trí slider: {{ $slider->position }}</p>
                                                    @if ($slider->cat_pro_id == 0)
                                                        <p>Danh mục: Trang chủ</p>
                                                    @else
                                                        <p>Danh mục: {{ $slider->categoryProduct->name }}</p>
                                                    @endif
                                                    @if ($slider->box == 0)
                                                        <p>Slider hiển thị: Chính</p>
                                                    @else
                                                        <p>Slider hiển thị: Phụ</p>
                                                    @endif

                                                </td>
                                                <td>{{ $slider->user->name }}</td>
                                                <td>{{ date('d/m/Y', strtotime($slider->created_at)) }}</td>
                                            </tr>
                                        @endcan
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="bg-white">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </form>


                {{ $sliders->withQueryString()->links('vendor.pagination.bootstrap-4') }}

            </div>
        </div>



    </div>
@endsection

@section('js')
    <script src="{{ asset('backend/slider/slider.js') }}"></script>
@endsection
