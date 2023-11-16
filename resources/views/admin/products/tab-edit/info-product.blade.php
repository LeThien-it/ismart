<div class="form-group mt-3">
    <h6><label>Tên sản phẩm:</label></h6>
    <input class="form-control" type="text" name="name" value="{{ $product->name }}">
    @error('name')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

<div class="form-group">
    <h6><label>Mô tả sản phẩm:</label></h6>
    <textarea name="content" class="form-control content-tiny" cols="30"
        rows="15">{{ $product->content }}</textarea>
    @error('content')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>


<div class="form-group">
    <h6>Danh mục:</h6>
    <select class="form-control js-select-2" name="category_product_id">
        <option value="">Chọn danh mục</option>
        @foreach ($htmlOption as $k => $v)
            @if ($product->category_product_id === $k)
                <option selected value="{{ $k }}">{{ $v }}</option>
            @else
                <option value="{{ $k }}">{{ $v }}</option>
            @endif
        @endforeach
    </select>
    @error('category_product_id')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

<div class="form-group">
    <h6>Sản phẩm nổi bật:</h6>
    <div class="form-check">
        <input class="form-check-input" name="featured" type="checkbox" value="1" id="featured"
            {{ $product->featured == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="featured">
            Nổi bật
        </label>
    </div>
</div>

<div class="form-group">
    <h6>Trạng thái:</h6>

    <div class="form-check">
        <input class="form-check-input" name="status" type="radio" value="0" id="status" {{ $product->status == 0 ? 'checked' : ''}}>
        <label class="form-check-label" for="status">
            Chờ duyệt
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" name="status" type="radio" value="1" id="status1" {{ $product->status == 1 ? 'checked' : ''}}>
        <label class="form-check-label" for="status1">
            Công khai
        </label>
    </div>
</div>
