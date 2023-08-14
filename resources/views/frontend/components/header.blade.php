<div id="header-wp">
    <div id="header-top">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <a href="{{ route('frontend.home.index') }}" title="" id="logo">
                    <img src="{{ asset('frontend/public') }}/images/logo.png" />
                </a>
                <div id="search-wp">
                    <form method="GET" action="{{ route('frontend.product.search') }}" autocomplete="off"
                        class="d-flex">
                        <input type="text" name="key" id="search-ajax"
                            placeholder="Nhập tên sản phẩm cần tìm kiếm" value="{{ request()->input('key') }}"
                            data-url="{{ route('frontend.product.suggestions') }}">
                        {{-- <button type="submit" id="sm-s">Tìm kiếm</button> --}}
                        <button type="submit" id="sm-s">
                            {{-- <img src="{{ asset('frontend/public/images/search.png') }}" alt=""> --}}
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div id="search-result"></div>
                </div>
                <div id="action-wp" class="d-flex align-items-center">
                    <div id="advisory-wp">
                        <span class="title">Tư vấn</span>
                        <span class="phone">0768.621.675</span>
                    </div>
                    <div id="cart-wp">
                        <div id="btn-cart">
                            <a href="{{ route('cart.show') }}">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">{{ Cart::count() }}</span>
                            </a>
                        </div>
                    </div>
                    <div id="btn-respon"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div id="header-bottom">
        <div class="container">
            <div id="main-menu" class="row align-items-center">
                <nav>
                    <ul class="nav menu justify-content-between align-items-center">
                        @foreach ($catProducts as $catProduct)
                            <li>
                                <a href="{{ route('frontend.product.category', ['slug' => $catProduct->slug]) }}">
                                    {!! optional($catProduct)->class !!}
                                    {{ $catProduct->name }}
                                </a>
                                @if ($catProduct->childrenCategorys->count() > 0)
                                    <ul class="dropdown">
                                        @foreach ($catProduct->childrenCategorys as $catChild)
                                            <li>
                                                <a
                                                    href="{{ route('frontend.product.category', ['slug' => $catChild->slug]) }}">
                                                    {{ str_replace($catProduct->name, '', $catChild->name) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                        <li><a href="{{ route('frontend.post.show') }}">24h Công nghệ</a></li>
                        @foreach ($pages as $page)
                            <li>
                                <a href="{{ route('frontend.page.detail', $page->slug) }}">
                                    {{ $page->name }}
                                </a>

                            </li>
                        @endforeach
                    </ul>
                </nav>

            </div>

        </div>

    </div>

</div>
