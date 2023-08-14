@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/cart.css') }}">
@endsection

@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="container">
            <div class="row section" id="breadcrumb-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('frontend.home.index') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            Giỏ hàng
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row flex-column">
                @if (Cart::count() > 0)
                    <div class="section" id="info-cart-wp">
                        <div class="section-detail table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <td width="10%">Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td width="11%">Màu sản phẩm</td>
                                        <td width="11%">Giá sản phẩm</td>
                                        <td width="12%">Số lượng</td>
                                        <td>Thành tiền</td>
                                        <td width="8%">Thao tác</td> --}}
                                        
                                        <td>Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td>Màu sản phẩm</td>
                                        <td>Giá sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Thành tiền</td>
                                        <td>Thao tác</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $row)
                                        <tr>
                                            <td>
                                                <a href="{{ route('frontend.product.detail', ['slug' => $row->options->slug, 'productSlug' => $row->options->productSlug, 'code' => $row->id]) }}"
                                                    title="" class="thumb">
                                                    <img class="img-thumbnail" src="{{ asset($row->options->image_path) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('frontend.product.detail', ['slug' => $row->options->slug, 'productSlug' => $row->options->productSlug, 'code' => $row->id]) }}"
                                                    class="name-product">{{ $row->name }}</a>
                                            </td>
                                            <td>{{ $row->options->color }}</td>
                                            <td>{{ number_format($row->price, 0, '.', '.') }}₫</td>
                                            <td>
                                                <div class="url-update" data-url="{{ route('cart.update') }}">
                                                    <a class="minus"><i class="fa fa-minus"></i></a>
                                                    <input type="text" name="qty" value="{{ $row->qty }}"
                                                        class="num-order" data-rowid="{{ $row->rowId }}">
                                                    <a class="plus"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </td>
                                            <td class="sub-total-{{ $row->rowId }}">
                                                {{ number_format($row->subtotal, 0, '.', '.') }}₫</td>
                                            <td>
                                                <a href="{{ route('cart.delete', $row->rowId) }}"
                                                    class="btn btn-danger del-product">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <p id="total-price" class="float-right">Tổng giá:
                                                    <span>{{ Cart::subtotal() }}₫</span>
                                                </p>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <div class="float-right">
                                                    <a href="{{ route('cart.pay') }}"
                                                        id="checkout-cart">Thanh
                                                        toán</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="section" id="action-cart-wp">
                        <div class="section-detail">
                            <p class="title">Click vào <span>“+ hoặc -”</span> để cập nhật số lượng. Nhấn vào thanh toán để
                                hoàn tất mua hàng.
                            </p>
                            <a href="{{ route('cart.destroy') }}" id="delete-cart">Xóa giỏ hàng</a>
                        </div>
                    </div>
                @else
                    <div class="empty">
                        <img src="{{ asset('frontend/public/images/empty-cart.png') }}">
                        <div class="mb-3">Không có sản phẩm nào trong giỏ hàng</div>
                        <a href="{{ route('frontend.home.index') }}" class="btn btn-primary">VỀ TRANG CHỦ</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            // CHOOSE NUMBER ORDER
            $(".plus").click(function() {
                $(this).parent().find(".minus").prop("disabled", false);
                var input_num = $(this).prev("input[name=qty]");
                var value = parseInt(input_num.attr("value"));
                value++;
                var rowId = input_num.data("rowid");
                input_num.attr("value", value);
                updateProductCart(rowId, value);
            });
            $(".minus").click(function() {
                var input_num = $(this).next("input[name=qty]");
                var value = parseInt(input_num.attr("value"));
                if (value > 1) {
                    value--;
                    var rowId = input_num.data("rowid");
                    input_num.attr("value", value);
                    updateProductCart(rowId, value);
                }
                if (value == 1) {
                    // $(this).addClass("disabled");
                    $(this).next('input[name=qty]').prop("disabled", true);
                }
            });

            function updateProductCart(rowId, qty) {
                var urlUpdate = $(".url-update").data("url");
                $.ajax({
                    url: urlUpdate,
                    method: "GET",
                    data: {
                        rowId: rowId,
                        qty: qty
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 200) {
                            $(".sub-total-" + rowId + "").text(data.subTotal + "₫");
                            $('#btn-cart #num').text(data.num_pro);
                            $(".qty-" + rowId + "").text(data.qty);
                            $("#total-price span").text(data.total + "₫");
                            // console.log(data.item);
                        }
                    },
                });
            }

        })
    </script>
@endsection
