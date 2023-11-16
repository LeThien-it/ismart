@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/blog.css') }}">
@endsection

@section('content')
    <div id="main-content-wp" class="blog-page">
        <div class="container ">
            <div class="blog-page-wp">
                <div class="row" id="breadcrumb-wp">
                    <div class="secion-detail">
                        <ul class="list-item">
                            <li>
                                <a href="{{ url('/') }}" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="" title="">24h Công nghệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="sidebar-blog">
                        <div class="section" id="selling-wp">
                            <div class="section-head">
                                <h3 class="section-title">Sản phẩm bán chạy</h3>
                            </div>
                            <div class="section-detail">
                                <ul class="list-item">
                                    @foreach ($bestSellingProducts as $sale)
                                        <li>
                                            <a href="{{ route('frontend.product.detail', ['slug' => getSlugByCatId($sale->product->category_product_id), 'productSlug' => $sale->product->slug, 'code' => $sale->id]) }}"
                                                title="" class="thumb">
                                                <img src="{{ asset($sale->feature_image_path) }}" alt="">
                                            </a>
                                            <div class="info">
                                                <a href="{{ route('frontend.product.detail', ['slug' => getSlugByCatId($sale->product->category_product_id), 'productSlug' => $sale->product->slug, 'code' => $sale->id]) }}"
                                                    title="" class="product-name">{{ $sale->product->name }}</a>
                                                <div class="price">
                                                    <span class="new">{{ number_format($sale->price, 0, ',', '.') }}đ</span>
                                                    @if ($sale->price_old)
                                                        <span
                                                            class="old">{{ number_format($sale->price_old, 0, ',', '.') }}đ</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="section" id="banner-wp">
                            <div class="section-detail">
                                <a href="?page=detail_blog_product" title="" class="thumb">
                                    <img src="public/images/banner.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="main-content-blog">
                        <div class="section" id="list-blog-wp">
                            <div class="section-head mb-3">
                                <ul class="d-flex">
                                    <li class="mr-4 {{ session('url') == true ? 'border-active' : '' }}"
                                    >
                                        <a href="{{ route('frontend.post.show') }}" style="color: black;">Tin mới</a>
                                    </li>
                                    @foreach ($catPostLinks as $catPostLink)
                                        <li class="mr-4 {{ request()->slug ? ($catPostLink->slug == request()->slug ? 'border-active' : '') : '' }}"
                                        >
                                            <a href="{{ route('frontend.post.show', $catPostLink->slug) }}"
                                                style="color: black;">{{ $catPostLink->name }}</a>
                                        </li>
                                    @endforeach
    
                                </ul>
                            </div>
    
                            <div class="section-detail mb-3">
                                <ul class="list-item">
                                    @foreach ($posts as $post)
                                        <li>
                                            <a href="{{ route('frontend.post.detail', ['slug' => $post->categoryPost->slug, 'slugPost' => $post->slug]) }}"
                                                class="thumb">
                                                <img src="{{ asset($post->post_image_path) }}"
                                                    alt="{{ $post->post_image_name }}">
                                            </a>
                                            <div class="info">
                                                <a href="{{ route('frontend.post.detail', ['slug' => $post->categoryPost->slug, 'slugPost' => $post->slug]) }}"
                                                    title="{{ $post->title }}" class="title">{{ $post->title }}
                                                </a>
                                                <span class="create-date">{{ $post->created_at->diffForHumans() }}</span>
                                                <div class="desc">{!! $post->desc !!}</div>
                                            </div>
                                        </li>
                                    @endforeach
    
                                </ul>
                            </div>
                            {{ $posts->withQueryString()->links() }}
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
@endsection
