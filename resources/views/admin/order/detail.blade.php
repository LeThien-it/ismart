@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/product/list/list.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (Session('status'))
                <div class="alert alert-success">
                    {{ Session('status') }}
                </div>
            @endif
            @if (Session('error'))
                <div class="alert alert-danger">
                    {{ Session('error') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thông tin đơn hàng</h5>

            </div>

            <div class="card-body">
                <form action="{{ route('order.update', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-action form-inline">
                        <table class="table table-striped table-bordered table-checkall">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width:20%">Mã đơn hàng</th>
                                    <td>{{ $order->order_code }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Khách hàng</th>
                                    <td>{{ $order->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Số điện thoại</th>
                                    <td>{{ $order->customer->phone }}</td>

                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Địa chỉ</th>
                                    <td>{{ $order->customer->address }}</td>

                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Email</th>
                                    <td>{{ $order->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Ngày tạo</th>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($order->customer->created_at)) }}</td>

                                </tr>
                                <tr>
                                    <th scope="row" style="width:20%">Chú thích</th>
                                    <td>{{ $order->note }}</td>

                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group mt-3">
                            <h5>
                                <i class="fas fa-info-circle"></i>
                                <span>Tình trạng đơn hàng:</span>
                            </h5>
                            <div class="form-group ml-3">
                                <select class="form-control mr-3" id="" name="status">
                                    <option value="">Chọn tác vụ</option>
                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang giao hàng
                                    </option>
                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Hủy đơn hàng
                                    </option>
                                </select>
                                <input type="submit" value="Cập nhật đơn hàng" class="btn btn-primary">
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Đơn hàng chi tiết</h5>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered table-checkall mt-3">
                    <thead>
                        <tr>
                            <th scope="col" width="12%">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Màu sắc</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $order_detail)
                            <tr>
                                <td><img class="img-thumbnail"
                                        src="{{ asset($order_detail->product_image) }}" alt="">
                                </td>
                                <td>{{ $order_detail->product_name}}</td>
                                <td>{{ $order_detail->product_color }}</td>
                                <td>{{ number_format($order_detail->price, 0, '.', '.') }}đ</td>
                                <td>{{ $order_detail->qty }}</td>
                                <td>{{ number_format($order_detail->price * $order_detail->qty, 0, '.', '.') }}đ
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right;">Tổng giá trị đơn hàng:</th>
                            <td>{{ number_format($order->total, 0, '.', '.') }}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection
