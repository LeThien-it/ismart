@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/home.css') }}">
@endsection

@section('content')
    <div id="main-content-wp" class="home-page">
        <div class="container px-0 ">
            <section class="slider">
                <div class="slider-content row no-gutters">
                    <div class="slider-content-left col-lg-8 col-md-8 col-12 pr-md-3">
                        <div id="sync1" class="slider-banner owl-carousel owl-theme">

                            @foreach ($sliders as $slider)
                                <div class="item">
                                    <a>
                                        <img class= "img-fluid" src="{{ asset($slider->image_path) }}" />
                                    </a>
                                </div>
                            @endforeach

                        </div>
                        <div id="sync2" class="slider-banner owl-carousel owl-theme">
                            @foreach ($sliders as $slider)
                                <div class="item">
                                    <h3>{!! $slider->title !!}</h3>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- Banner hot -->
                    <div class="slider-content-right col-lg-4 col-md-4 col-12">
                        @foreach ($banner_subs as $banner_sub)
                            <div class="img">
                                <img class="img-fluid" src="{{ asset($banner_sub->image_path) }}" alt="" />
                            </div>
                        @endforeach
                    </div>
                    <!-- End -->
                </div>
            </section>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="d-flex flex-md-row">
                        <li>
                            <div class="thumb">
                                <img class="mx-auto" src="{{ asset('frontend') }}/public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>

                        <li>
                            <div class="thumb">
                                <img class="mx-auto" src="{{ asset('frontend') }}/public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>

                        <li>
                            <div class="thumb">
                                <img class="mx-auto" src="{{ asset('frontend') }}/public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>

                        <li>
                            <div class="thumb">
                                <img class="mx-auto" src="{{ asset('frontend') }}/public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>

                        <li>
                            <div class="thumb">
                                <img class="mx-auto" src="{{ asset('frontend') }}/public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <section>
                <div class="product-area mt-4">
                    @foreach ($catProductParent as $cat)
                        @php
                            $list_products = showProductHome($cat->slug);
                            $text = '';
                        @endphp
                        @if ($loop->first)
                            @php
                                $text = ' nổi bật';
                            @endphp
                        @endif
                        @include('frontend.home.components.product')
                        <div class="mt-4"></div>
                    @endforeach
                   
                </div>
            </section>

        </div>
    </div>
@endsection
