@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/product/list/list.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
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
                    <a href="{{ route('order.list', ['kind' => 'all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>

                    <a href="{{ route('order.list', ['kind' => 'processing']) }}" class="text-primary">Đang xử lý<span
                            class="text-muted">({{ $count[1] }})</span></a>

                    <a href="{{ route('order.list', ['kind' => 'delivering']) }}" class="text-primary">Đang giao
                        hàng<span class="text-muted">({{ $count[2] }})</span></a>

                    <a href="{{ route('order.list', ['kind' => 'done']) }}" class="text-primary">Hoàn thành<span
                            class="text-muted">({{ $count[3] }})</span></a>

                    <a href="{{ route('order.list', ['kind' => 'cancel']) }}" class="text-primary">Hủy đơn hàng<span
                            class="text-muted">({{ $count[4] }})</span></a>

                    <a href="{{ route('order.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span
                            class="text-muted">({{ $count[5] }})</span></a>
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
                <form action="{{ route('order.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_order')
                            <select class="form-control mr-1" id="" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary">
                        @endcan

                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Tổng giá</th>
                                    <th scope="col">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->count() > 0)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="listCheck[]" value="{{ $order->id }}">
                                            </td>
                                            <td scope="row">{{ $order->id }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->order_code }} </td>

                                            <td>
                                                {{ $order->orderDetails->sum('qty') }}
                                            </td>
                                            <td>{{ number_format($order->total, 0, '.', '.') }}đ</td>
                                            <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="bg-white">
                                            Không tìm thấy bản ghi nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
