<div class="sidebar d-none d-md-block">
    <div class="section pr-3" id="filter-product-wp">
        <div class="section-detail card p-2">
            <div class="form-group">
                <label class="h6" for="">Hãng sản xuất</label>
                @foreach ($brandFilter->childrenCategorys as $brandChild)
                    <div class="form-check">
                        <input class="form-check-input brand" type="checkbox" name="r_brand[]"
                            id="{{ $brandChild->name }}" value="{{ $brandChild->id }}"
                            @if (request()->r_brand) @if (in_array($brandChild->id, request()->r_brand))
                                    {{ 'checked' }} @endif
                        @else {{ '' }} @endif
                        >
                        <label class="form-check-label" for="{{ $brandChild->name }}">
                            @if ($brand->parentCategory)
                                {{ str_replace($brand->parentCategory->name, '', $brandChild->name) }}
                            @else
                                {{ str_replace($brand->name, '', $brandChild->name) }}
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
            <hr>

            <div class="form-group">
                <label class="h6" for="">Mức giá</label>

                <div class="form-check">
                    <input class="form-check-input" checked type="radio" name="r_price" id="price-all" value="">
                    <label class="form-check-label" for="price-all">
                        Tất cả
                    </label>
                </div>

                {!! form_check_price('2t', 'Dưới 2 triệu') !!}
                {!! form_check_price('2-4t', 'Từ 2 - 4 triệu') !!}
                {!! form_check_price('4-7t', 'Từ 4 - 7 triệu') !!}
                {!! form_check_price('7-13t', 'Từ 7 - 13 triệu') !!}
                {!! form_check_price('13t', 'Trên 13 triệu') !!}
            </div>
            <input type="submit" value="Xem kết quả" class="btn btn-primary w-100" />
        </div>
    </div>
</div>
