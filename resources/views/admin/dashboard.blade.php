@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3 h-100" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }} đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card text-white bg-success mb-3 h-100" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-warning mb-3 h-100" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>


            <div class="col">
                <div class="card text-white bg-info mb-3 h-100" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG ĐANG GIAO</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[3] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3 h-100" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[4] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- end analytic  -->
        <div class="card mt-4">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
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
                            @if (request()->kind == 'trash')
                            @else
                                <th scope="col">Trạng thái</th>
                                @can('update', App\Order::class)
                                    <th scope="col">Tác vụ</th>
                                @endcan
                            @endif
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
                                    <td>{{ optional($order->customer)->name }}</td>
                                    <td>{{ $order->order_code }} </td>

                                    <td>
                                        {{ $order->orderDetails->sum('qty') }}
                                    </td>
                                    <td>{{ number_format($order->total, 0, '.', '.') }}đ</td>
                                    <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>

                                    @if (request()->kind == 'trash')
                                    @else
                                        <td>
                                            <span class="{{ $order->getStatus()['class'] }}">
                                                {{ $order->getStatus()['name'] }}
                                            </span>
                                        </td>
                                        @can('update', $order)
                                            <td>
                                                <a href="{{ route('order.detail', ['id' => $order->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="detail"><i
                                                        class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        @endcan
                                    @endif

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
                {{ $orders->withQueryString()->links() }}

            </div>
        </div>

    </div>
@endsection
