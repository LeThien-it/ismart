@php
    use App\CategoryProduct;
@endphp

<div class="list-product d-flex flex-wrap">
    {{-- {{ dd($products) }} --}}
    @if (count($products) > 0)
        @foreach ($products as $key => $product)
            @php
                $catPro = CategoryProduct::find($product->category_product_id);
                $slug = $catPro->ultimateParent()->slug;
            @endphp

            <div class="col-6 col-sm-4 col-lg-4 col-xl-3 px-0 mb-3">
                <div class="item card">
                    <a
                        href="{{ route('frontend.product.detail', ['slug' => $slug, 'productSlug' => $product->slug, 'code' => $product->variant_id]) }}">
                        <div class="item-img">
                            <img src="{{ asset($product->feature_image_path) }}" alt="Tên sản phẩm" />
                        </div>

                        <div class="card-body p-0">
                            <h3 class="card-title">{{ $product->name }}</h3>
                            <div class="box-p">
                                <strong class="price">{{ number_format($product->price, 0, '.', '.') }}₫
                                </strong>
                                @if ($product->price_old)
                                    <p class="price-old">
                                        {{ number_format($product->price_old, 0, '.', '.') }}₫
                                    </p>
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
            </div>
        @endforeach
    @else
        <div class="text-center d-flex flex-column align-items-center w-100">
            <img src="{{ asset('frontend/public/images/noti-search.png') }}" alt="">
            <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn</p>
            <p>Vui lòng thử lại .</p>
        </div>
    @endif

</div>
