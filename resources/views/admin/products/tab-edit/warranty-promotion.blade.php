<div class="form-group mt-3">
    <label for="tinymce">Bảo hành</label>
    <textarea name="warranty" class="form-control content-tiny" id="tinymce" rows="10">
        {{ $product->warranty }}</textarea>
    @error('warranty')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="tinymce">Khuyến mãi</label>
    <textarea name="promotion" class="form-control content-tiny" id="tinymce"
        rows="10">{{ $product->promotion }}</textarea>
    @error('promotion')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
