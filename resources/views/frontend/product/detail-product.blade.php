@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/detail_product.css') }}">
@endsection

@section('content')
    @php
        $variant = getId('App\ProductVariant', request('code'));
    @endphp
    <div id="main-content-wp" class="detail-product-page">
        <div class="main-content-head">
            <div class="container">
                <div class="row" id="breadcrumb-wp">
                    <div class="secion-detail">
                        <ul class="list-item">
                            <li>
                                <a href="{{ url('/') }}" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{ url(request()->slug) }}" title="">{{ getSlug(request()->slug)->name }}</a>
                            </li>
                            <li>
                                <a href="{{ url(checkParentCategory($product->category_product_id)->slug) }}"
                                    title="">{{ checkParentCategory($product->category_product_id)->name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <section class="row detail-product py-lg-3 pt-3 pb-0">
                    <div class="product-name col-12 px-0">
                        <h5>
                            {{ $variant->product->name }}
                        </h5>
                        <hr />
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-5 col-9 px-0 mx-auto">
                                <div class="product-single-gallery pr-lg-3">
                                    <div id="sync-big" class="slider-big owl-carousel owl-theme">
                                        @foreach ($variant->images as $image)
                                            {{-- <div class="item">
                                            </div> --}}
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $image->image_name }}" class="img-fluid"/>
                                        @endforeach
                                    </div>
                                    <div id="sync-small" class="slider-small owl-carousel owl-theme mx-auto">
                                        @foreach ($variant->images as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="{{ $image->image_name }}"
                                            class="img-fluid" />
                                            {{-- <div class="item">
                                            </div> --}}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 px-0">
                                <div class="product-des pr-lg-3">
                                    <div class="product-price d-flex">
                                        <p class="price">{{ number_format($variant->price, 0, '.', '.') }}₫</p>
                                        @if ($variant->price_old)
                                            <span
                                                class="old-price">{{ number_format($variant->price_old, 0, '.', '.') }}₫</span>
                                        @endif
                                    </div>
                                    <div class="product-select">
                                        @if (!empty($memorys))
                                            <div class="product-select-top d-flex mb-2">
                                                @foreach ($memorys as $k => $memory)
                                                    <a class="{{ request()->productSlug == $productSlugs[$k] ? 'active' : '' }}"
                                                        href="{{ route('frontend.product.detail', ['slug' => request()->slug, 'productSlug' => $productSlugs[$k], 'code' => $k]) }}">{{ $memory }}</a>
                                                @endforeach

                                            </div>
                                        @endif
                                        <!-- Color -->
                                        <div class="product-select-bottom d-flex flex-wrap mb-2">
                                            @foreach ($arr as $key => $item)
                                                @if ($item['productSlug'] == request()->productSlug)
                                                    <a class="{{ request()->code == $item['code'] ? 'active' : '' }}"
                                                        href="{{ route('frontend.product.detail', ['slug' => request()->slug, 'productSlug' => $item['productSlug'], 'code' => $item['code']]) }}">{{ $item['color'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="product-promotion card mt-3">
                                        <div class="promotion-head card-header">
                                            <p>Khuyến mãi</p>
                                        </div>
                                        <div class="card-body">
                                            {!! $variant->product->promotion !!}
                                        </div>

                                    </div>

                                    <div class="product-buy mt-2 mb-3">
                                        <div class="btn-muangay mb-2">
                                            <a href="{{ route('cart.add', ['id' => request()->code]) }}"
                                                data-toggle="modal" data-target="#add-cart"
                                                data-src="{{ asset(getImage(request()->code)) }}">
                                                <div>
                                                    <b>Mua ngay</b>
                                                    <span>(Giao hàng tận nơi thu tiền trên toàn quốc)</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @include('frontend.product.modal.modal-cart')
                                </div>
                            </div>
                            <div class="col-lg-3 px-0 mb-3">
                                <div class="pro-info-sidebar">
                                    <div class="product-promotion card">
                                        <div class="promotion-head card-header">
                                            <p>Bảo hành</p>
                                        </div>
                                        <div class="card-body">
                                            {!! $variant->product->warranty !!}
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>


            </div>
        </div>
        <div class="main-content-body mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 px-0 pr-lg-3">
                        <div class="card">
                            <h5 class="h5 pt-3 text-center">Đặc điểm nổi bật</h5>
                            <div class="card-body pt-0">
                                <div class="desc_cat">
                                    <div class="load-content text-justify">
                                        {!! $product->content !!}
                                    </div>
                                    <p class="loadmoredesc">
                                        <a href="">Xem thêm
                                            <i class="fa fa-caret-down"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="review" class="card mt-3">
                            <h5 class="h5">Đánh giá & Nhận xét {{ $product->name }}</h5>
                            <div class="rating-vote">
                                <div class="vote">
                                    <div class="vote-left">
                                        <p class="rating-average">{{ $avgStar }}/5</p>
                                        <div class="rating-star">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $avgStar ? 'active' : '' }}"></i>
                                            @endfor

                                        </div>
                                        <p class="rating-total"><strong>{{ $rating_total }}</strong> đánh giá &amp; nhận
                                            xét</p>
                                    </div>
                                    <div class="vote-right">
                                        @for ($i = 5; $i > 0; $i--)
                                            <div class="item-progress">
                                                <p class="number-star"><strong>{{ $i }}</strong>&nbsp;<i
                                                        class="fas fa-star"></i>
                                                </p>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                        @if ($ratingDefault[$i]['rating_count'] > 0) style="width: {{ round(($ratingDefault[$i]['rating_count'] / $rating_total) * 100, 1) }}%"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @else 
                                                            style="width: 0%"
                                                            aria-valuemin="0" aria-valuemax="100"> @endif
                                                        </div>
                                                    </div>
                                                    <p class="count-evaluate">{{ $ratingDefault[$i]['rating_count'] }}
                                                      <span>đánh giá</span>
                                                    </p>
                                                </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="button-vote mt-3">
                                    <p class="mb-1">bạn đánh giá sao về sản phẩm này ?</p>
                                    <a data-toggle="modal" data-target="#review-modal">Đánh giá
                                        ngay</a>
                                    @include('frontend.product.modal.modal-review')
                                </div>
                                <div class="list-user-comment mt-4">
                                    <div class="list-comment" id="list-comment-id">
                                        @include('frontend.include.include_list_rating')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0 pl-lg-3 mt-4 mt-lg-0">
                        <div class="card p-3">
                            <h5 class="h5">Thông số kỹ thuật</h5>
                            <div class="parameter">

                                {!! $product->parameter !!}
                            </div>
                            <div class="btn-show-parameter mt-3 text-center border">
                                <a href="" class="w-100" data-toggle="modal" data-target="#parameter-detail">Xem
                                    cấu hình chi tiết</a>
                            </div>

                            @include('frontend.product.modal.modal-parameter')
                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-12 px-0 mt-3">
                        <div class="section" id="same-category-wp">
                            <div class="section-head">
                                <h3 class="section-title">Xem thêm {{ $cat->name }} khác:</h3>
                            </div>
                            <div class="section-detail">
                                <div class="list-product same-product owl-carousel">
                                    @foreach ($sameCats as $product_cat)
                                        <div class="item card">
                                            <a
                                                href="{{ route('frontend.product.detail', ['slug' => $cat->slug, 'productSlug' => $product_cat->slug, 'code' => $product_cat->variant_id]) }}">
                                                <div class="item-img">
                                                    <img src="{{ asset($product_cat->feature_image_path) }}"
                                                        alt="Tên sản phẩm" />
                                                </div>

                                                <div class="card-body p-0">
                                                    <h3 class="card-title">{{ $product_cat->name }}</h3>

                                                    <div class="box-p">
                                                        <p class="price">
                                                            {{ number_format($product_cat->price, 0, '.', '.') . '₫' }}
                                                        </p>
                                                        @if ($product_cat->price_old)
                                                            <p class="price-old">
                                                                {{ number_format($product_cat->price_old, 0, '.', '.') . '₫' }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    @if (checkRating($product_cat->id))
                                                        <div class="box-rating-star">
                                                            @php
                                                                $ratingStar = getRatingStar($product_cat->id);
                                                            @endphp
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fas fa-star {{ $i <= $ratingStar[0] ? 'active' : '' }}"></i>
                                                            @endfor
                                                            <span>{{ $ratingStar[1] }} đánh giá</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $(".btn-muangay a").click(function(event) {
                event.preventDefault();
                var href = $(this).attr('href');
                var urlCurrent = window.location.pathname;
                var newURL = window.location.href,
                    pathArray = newURL.split('/'),
                    secondLevelLocation = pathArray[0];
                var urlImage = $(this).data('src');
                $("#add-cart .modal-body img.img-modal").attr("src", urlImage);

                $.ajax({
                    url: href,
                    method: "GET",
                    dataType: "json",
                    data: {
                        slug: pathArray[4]
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            $("#btn-cart #num").text(data.num);
                            $("#add-cart .modal-body .modal-pro-name>b").html(data.name);
                            $("#add-cart").modal('show');
                        }
                    },
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#ratingId li").mouseover(function() {
                var current = $(this);
                $("#ratingId li i").each(function(index) {
                    $(this).addClass("hovered-stars");
                    if (index == current.index()) {
                        return false;
                    }
                })
            });

            $("#ratingId li").mouseleave(function() {
                $("#ratingId li i").removeClass('hovered-stars');
            });


            $("#ratingId li").click(function(event) {
                $("#ratingId li i").removeClass("clicked-stars");
                $(".hovered-stars").addClass("clicked-stars");
                var a = $(".clicked-stars").length;

            })

            $(".select-bottom-item").click(function() {
                $(".select-bottom-item").removeClass("active");
                $(this).addClass('active');
            })
        })
    </script>
    <script>
        $(document).ready(function() {

            $('.js-review').click(function(event) {
                event.preventDefault();
                // var href = $(this).attr('href');
                var urlReview = $('#review-modal .modal-body form').attr('action');
                var name = $('#review-modal input[name=name]').val();
                var phone = $('#review-modal input[name=phone]').val();
                var address = $('#review-modal input[name=address]').val();
                var email = $('#review-modal input[name=email]').val();
                var content = $('#review-modal textarea[name=content]').val();
                // console.log(name)
                var num_star = $(".clicked-stars").length;
                // $("#add-cart .modal-body img.img-modal").attr("src", urlImage);

                // console.log(urlReview)  
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: urlReview,
                    method: "POST",
                    data: {
                        name: name,
                        phone: phone,
                        email: email,
                        address: address,
                        content: content,
                        num_star: num_star
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 200) {
                            // console.log(data.variant);
                            window.location = window.location.href;
                        }
                    },
                });
            });

            $('body').on('click', '.pagination a', function(event) {
                event.preventDefault();
                var urlNew = $(this).attr('href');
                // var page = $(this).attr('href').split('page=')[1];
                console.log(urlNew);
                getListRatings(urlNew);
            });

            function getListRatings(urlNew) {
                $.ajax({
                    type: "GET",
                    url: urlNew,
                    dataType: "json",
                    success: function(data) {
                        $('.list-comment').html(data.html);
                    },
                });

            }
        })
    </script>
@endsection
