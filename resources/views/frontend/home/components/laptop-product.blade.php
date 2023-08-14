<div class="col-12 px-0">
    <div class="product-feature">
        <div class="product-top">
            <h2 class="product-title">
                Laptop
            </h2>
            <a class="button-pill"
                href="{{ route('frontend.product.category', ['slug' => 'laptop', 'sort' => 'latest']) }}">Xem tất
                cả</a>
        </div>

        <div class="list-product slider-product owl-carousel">
            @foreach ($laptops[1] as $laptop)
                <div class="item card">
                    <a
                        href="{{ route('frontend.product.detail', ['slug' => $laptops[0]->slug, 'productSlug' => $laptop->slug, 'code' => $laptop->variant_id]) }}">
                        <div class="item-img">
                            <img src="{{ asset($laptop->feature_image_path) }}" alt="Tên sản phẩm" />
                        </div>

                        <div class="card-body p-0">
                            <h3 class="card-title">{{ $laptop->name }}</h3>

                            <div class="box-p">
                                <p class="price">
                                    {{ number_format($laptop->price, 0, '.', '.') . '₫' }}
                                </p>
                                @if ($laptop->price_old)
                                    <p class="price-old">
                                        {{ number_format($laptop->price_old, 0, '.', '.') . '₫' }}</p>
                                @endif
                            </div>
                            @if (checkRating($laptop->id))
                                <div class="box-rating-star">
                                    @php
                                        $ratingStar = getRatingStar($laptop->id);
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
