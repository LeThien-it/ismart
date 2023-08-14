<div id="menu-respon">
    <a href="{{ route('frontend.home.index') }}" title="" id="logo-respon">
        <img src="{{ asset('frontend/public') }}/images/logo.png" />
    </a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            @foreach ($catProducts as $catProduct)
                            <li>
                                <a href="{{ route('frontend.product.category', ['slug' => $catProduct->slug]) }}">
                                    {!! optional($catProduct)->class !!}
                                    {{ $catProduct->name }}
                                </a>
                                @if ($catProduct->childrenCategorys->count() > 0)
                                    <ul class="sub-menu">
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
    </div>
</div>