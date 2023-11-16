@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/category_product.css') }}">
@endsection

@section('content')
    <div class="category-product-wp pb-5">
        <div class="container">
            <div class="row" id="breadcrumb-wp">
                <ul class="list-item">
                    <li>
                        <a href="{{ route('frontend.home.index') }}" title="">Trang chủ</a>
                    </li>

                </ul>
            </div>
            @if (count($products) >= 1)
                <form action="" id="category-product">
                    <div class="row">
                        {{-- sidebar --}}
                        @include('frontend.product.components.sidebar-search')
                        {{-- end sidebar --}}

                        <div class="main-content">
                            <div class="section" id="list-product-wp">
                                <div class="product-area">

                                    <div class="section-detail">
                                        <div class="card py-3">
                                            <div class="filter-wp">
                                                <div class="form-filter">
                                                    <select name="sort">
                                                        <option value="">Sắp xếp</option>
                                                        {!! form_filter('latest', 'Mới nhất') !!}

                                                        {!! form_filter('high-to-low', 'Giá cao xuống thấp') !!}

                                                        {!! form_filter('low-to-high', 'Giá thấp lên cao') !!}
                                                    </select>
                                                    <button type="submit">Lọc</button>
                                                </div>
                                            </div>

                                            @include('frontend.product.components.list-product-search')
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $products->withQueryString()->links() }}
                            </div>

                        </div>


                    </div>
                </form>
            @else
            <div class="row">
                <div class="card col-12 w-100">
                    <div class="text-center d-flex flex-column align-items-center w-100 p-5">
                        <img src="{{ asset('frontend/public/images/noti-search.png') }}" alt="">
                        <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn</p>
                        <p>Vui lòng thử lại .</p>
                    </div>

                </div>
            </div>
            @endif

        </div>
    </div>
@endsection
