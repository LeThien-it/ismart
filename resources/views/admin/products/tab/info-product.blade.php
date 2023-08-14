<div class="form-group mt-3">
    <h6><label for="">Tên sản phẩm:</label></h6>
    <input class="form-control" type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

<div class="form-group">
    <h6><label for="tinymce">Mô tả sản phẩm</label></h6>
    <textarea name="content" class="form-control content-tiny" id="tinymce" cols="30" rows="15">{{ old('content') }}</textarea>
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
            <option value="{{ $k }}">{{ $v }}</option>
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
        <input class="form-check-input" name="featured" type="checkbox" value="1" id="featured">
        <label class="form-check-label" for="featured">
            Nổi bật
        </label>
    </div>
</div>

<div class="form-group">
    <h6>Trạng thái:</h6>

    <div class="form-check">
        <input class="form-check-input" name="status" type="radio" value="0" id="status" checked>
        <label class="form-check-label" for="status">
            Chờ duyệt
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" name="status" type="radio" value="1" id="status1">
        <label class="form-check-label" for="status1">
            Công khai
        </label>
    </div>
</div>
