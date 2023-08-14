@extends('layouts.frontend')
@section('css')
    <style>
        .thank {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
@endsection
@section('content')
    <div id="main-content-wp" class="mx-auto pb-3">
        <div class="container">
            <div class="thank">
                <img src="{{ asset('frontend/public/images/thank.png') }}" alt="">
                <p class="text-center"><b>Cảm ơn quý khách hàng đã tin tưởng và mua sắm bên hệ thống Ismart Store</b></p>
                <p>- Ismart Store đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé , bạn sẽ nhận được thông báo tiếp
                    theo khi đơn hàng đã sẵn sàng được giao.</p>
                <p>- Đơn hàng dự kiến sẽ được giao trong vòng 2-3 ngày </p>
                <p>- Trước khi giao hàng tới quý khách sẽ có nhân viên giao hàng liên hệ với quý khách qua số điện thoại.
                </p>
                <p>- Sau khi nhận được hàng vui lòng quý khách kiểm tra hàng kỹ lưỡng và có thông tin gì cần cửa hàng hỗ trợ
                    thì có thể gọi đến số hotline của hệ thống để được giải đáp và kịp thời hỗ trợ.</p>
                <p>- Địa chỉ cửa hàng: Cát Lái, Quận 2 - TP HCM.</p>
                <p>- Số điện thoại cửa hàng: 0768621675</p>
                <p class="text-center my-3">
                    <a class="btn btn-success" title="Trở về trang chủ" href="{{ url('/') }}">
                        Trở về trang chủ
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
