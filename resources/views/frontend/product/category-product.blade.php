@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/category_product.css') }}">
@endsection

@section('content')
    <div class="category-product-wp px-1">
        <div class="container">
            <div class="row" id="breadcrumb-wp">
                <ul class="list-item">
                    <li>
                        <a href="{{ route('frontend.home.index') }}" title="">Trang chủ</a>
                    </li>
                    @if (request()->slug == $brand->slug)
                        <li>
                            {{ $brand->name }}
                        </li>
                    @endif
                </ul>
            </div>
            <div class="secion" id="banner-cat-pro-wp">
                <div class="row">
                    <div class="col-md-8 px-0">
                        <div class="banner-cat-main owl-carousel owl-theme ">
                            @foreach ($banner[0] as $banner_main)
                                @if ($banner_main->cat_pro_id != 0)
                                    @if ($banner_main->categoryProduct->slug == $brand->slug || $banner_main->categoryProduct->slug == $brandFilter->slug)
                                        <div class="item">
                                            <a>
                                                <img src="{{ asset($banner_main->image_path) }}" alt="">
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4 banner-cat-sub pr-0">
                        @foreach ($banner[1] as $banner_sub)
                            @if ($banner_sub->cat_pro_id != 0)
                                @if ($banner_sub->categoryProduct->slug == $brand->slug || $banner_sub->categoryProduct->slug == $brandFilter->slug)
                                    <div class="img">
                                        <img src="{{ asset($banner_sub->image_path) }}" alt="">
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <form action="{{ route('frontend.product.category', ['slug' => request()->slug]) }}" id="category-product">
                <div class="row">
                    {{-- sidebar --}}
                    @include('frontend.product.components.sidebar-category')
                    {{-- end sidebar --}}

                    <div class="main-content">
                        <div class="section" id="list-product-wp">
                            <div class="product-area">
                                <div class="section-head mb-4">
                                    <div class="card">
                                        <div class="card-head">
                                            <h4 class="h4 fl-left mb-0">
                                                @if (request()->r_brand)
                                                    @if ($brand->parentCategory)
                                                        {{ $brand->parentCategory->name }}
                                                    @else
                                                        {{ $brand->name }}
                                                    @endif

                                                    <span>({{ count($products) . ' sản phẩm' }})</span>
                                                @else
                                                    {{ $brand->name }}
                                                    <span>({{ count($products) . ' sản phẩm' }})</span>
                                                @endif
                                            </h4>
                                        </div>
                                    </div>

                                </div>
                                <div class="section-detail">
                                    <div class="card py-3">
                                        <div class="filter-wp">
                                            <div class="form-filter">
                                                <select name="sort">
                                                    <option value="">Sắp xếp</option>
                                                    {!! form_filter('latest', 'Mới nhất') !!}

                                                    {!! form_filter('discount', 'Giảm giá') !!}

                                                    {!! form_filter('high-to-low', 'Giá cao xuống thấp') !!}

                                                    {!! form_filter('low-to-high', 'Giá thấp lên cao') !!}
                                                </select>
                                                <button type="submit">Lọc</button>
                                            </div>
                                        </div>

                                        @include('frontend.product.components.list-product')
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
        </div>
    </div>
@endsection
