<div class="col-12 px-0">
    <div class="product-feature">
        <div class="product-top">
            <h2 class="product-title">
                Máy tính bảng
            </h2>
            <a class="button-pill"
            href="{{ route('frontend.product.category', ['slug' => $tablets[0]->slug, 'sort' => 'latest']) }}">Xem tất
                cả</a>
        </div>
                
        <div class="list-product slider-product owl-carousel">
            @foreach ($tablets[1] as $tablet)
                <div class="item card">
                    <a
                        href="{{ route('frontend.product.detail', ['slug' => $tablets[0]->slug, 'productSlug' => $tablet->slug, 'code' => $tablet->variant_id]) }}">
                        <div class="item-img">
                            <img src="{{ asset($tablet->feature_image_path) }}" alt="Tên sản phẩm" />
                        </div>

                        <div class="card-body p-0">
                            <h3 class="card-title">{{ $tablet->name }}</h3>

                            <div class="box-p">
                                <p class="price">
                                    {{ number_format($tablet->price, 0, '.', '.') . '₫' }}
                                </p>
                                @if ($tablet->price_old)
                                    <p class="price-old">
                                        {{ number_format($tablet->price_old, 0, '.', '.') . '₫' }}</p>
                                @endif
                            </div>

                            @if (checkRating($tablet->id))
                                <div class="box-rating-star">
                                    @php
                                        $ratingStar = getRatingStar($tablet->id);
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
