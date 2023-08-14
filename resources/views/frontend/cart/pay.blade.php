@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/checkout.css') }}">
@endsection

@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="container">
            <div class="row section-detail" id="breadcrumb-wp">
                <ul class="list-item">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <form method="POST" action="{{ route('cart.post.pay') }}" name="form-checkout"
                    class="flex-column flex-md-row">
                    @csrf
                    <div class="section" id="customer-info-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin khách hàng</h1>
                        </div>
                        <div class="section-detail">

                            <div class="form-row">
                                <div class="col">
                                    <label for="fullname">Họ tên</label>
                                    <input class="form-control" type="text" name="name" id="fullname">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col">
                                    <label for="address">Địa chỉ</label>
                                    <input class="form-control" type="text" name="address" id="address">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="phone">Số điện thoại</label>
                                    <input class="form-control" type="text" name="phone" id="phone">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Ghi chú</label>
                                <textarea class="form-control" id="notes" name="note"></textarea>
                                @error('note')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="section" id="order-review-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin đơn hàng</h1>
                        </div>
                        <div class="section-detail">
                            @foreach (Cart::content() as $info)
                                <div class="cart-item">
                                    <img class="img-thumbnail" src="{{ asset($info->options->image_path) }}" alt="">
                                    <div class="product-name">
                                        <p><strong>Tên sản phẩm:</strong> {{ $info->name }}</p>
                                        <p><strong>Số lượng:</strong> {{ $info->qty }}
                                        </p>
                                        <p><strong>Giá:</strong> {{ number_format($info->price, 0, ',', '.') }}₫</p>
                                        <p><strong>Thành tiền:</strong>
                                            {{ number_format($info->subtotal, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="order-total">
                                Tổng tiền:<span>{{ Cart::subtotal() }}₫</span>
                            </div>
                            {{-- <table class="shop-table">
                                <tbody>
                                    @foreach (Cart::content() as $info)
                                        <tr class="cart-item">
                                            <td>
                                                <img class="img-thumbnail" src="{{ asset($info->options->image_path) }}"
                                                    alt="">
                                            </td>
                                            <td class="product-name">
                                                <p>Tên sản phẩm: {{ $info->name }}</p>
                                                <p>Số lượng: <strong class="product-quantity">{{ $info->qty }}</strong>
                                                </p>
                                                <p>Giá: {{ number_format($info->price, 0, ',', '.') }}₫</p>
                                                <p class="product-total">Thành tiền:
                                                    {{ number_format($info->subtotal, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <td colspan="2">Tổng đơn hàng: <strong
                                                class="total-price">{{ Cart::subtotal() }}₫</strong></td>
                                    </tr>
                                </tfoot>
                            </table> --}}
                            <div id="payment-checkout-wp">
                                <ul id="payment_methods">
                                    <li>
                                        <input type="radio" id="direct-payment" checked>
                                        <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="place-order-wp clearfix">
                                <input type="submit" id="order-now" value="Đặt hàng">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
