<div class="col-12 px-0">
    <div class="product-feature">
        <div class="product-top">
            <h2 class="product-title">
                {{ $cat->name.$text  }}
            </h2>
            <a class="button-pill"
            href="{{ route('frontend.product.category', ['slug' => $cat->slug, 'sort' => 'latest']) }}">Xem tất
                cả</a>
        </div>
                
        <div class="list-product slider-product owl-carousel">
            @foreach ($list_products[1] as $product)
                <div class="item card">
                    <a
                        href="{{ route('frontend.product.detail', ['slug' => $cat->slug, 'productSlug' => $product->slug, 'code' => $product->variant_id]) }}">
                        <div class="item-img">
                            <img src="{{ asset($product->feature_image_path) }}" alt="Tên sản phẩm" />
                        </div>

                        <div class="card-body p-0">
                            <h3 class="card-title">{{ $product->name }}</h3>

                            <div class="box-p">
                                <p class="price">
                                    {{ number_format($product->price, 0, '.', '.') . '₫' }}
                                </p>
                                @if ($product->price_old)
                                    <p class="price-old">
                                        {{ number_format($product->price_old, 0, '.', '.') . '₫' }}</p>
                                @endif
                            </div>

                            @if (checkRating($product->id))
                                <div class="box-rating-star">
                                    @php
                                        $ratingStar = getRatingStar($product->id);
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $ratingStar[0] ? 'active' : '' }}"></i>
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
