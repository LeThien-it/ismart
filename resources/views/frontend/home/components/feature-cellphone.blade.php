<div class="col-12 px-0">
    <div class="product-feature">
        <div class="product-top">
            <h2 class="product-title">
                Điện thoại nổi bật
            </h2>
            <a class="button-pill"
                href="{{ route('frontend.product.category', ['slug' => 'dien-thoai', 'sort' => 'featured']) }}">Xem tất
                cả</a>
        </div>
        <div class="list-product slider-product owl-carousel">
            @foreach ($phone_features as $phone)
                <div class="item card">
                    <a
                        href="{{ route('frontend.product.detail', ['slug' => $catPhone->slug, 'productSlug' => $phone->slug, 'code' => $phone->variant_id]) }}">
                        <div class="item-img">
                            <img src="{{ asset($phone->feature_image_path) }}" alt="Tên sản phẩm" />
                        </div>

                        <div class="card-body p-0">
                            <h3 class="card-title">{{ $phone->name }}</h3>

                            <div class="box-p">
                                <p class="price">
                                    {{ number_format($phone->price, 0, '.', '.') . '₫' }}
                                </p>
                                @if ($phone->price_old)
                                    <p class="price-old">
                                        {{ number_format($phone->price_old, 0, '.', '.') . '₫' }}</p>
                                @endif
                            </div>
                            @if (checkRating($phone->id))
                                <div class="box-rating-star">
                                    @php
                                        $ratingStar = getRatingStar($phone->id);
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
