<div class="form-group mt-3">
    <h6>
        <label>Bảo hành:</label>
    </h6>
    <textarea name="warranty" class="form-control content-tiny" rows="10">
        {{ $product->warranty }}</textarea>
    @error('warranty')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
<div class="form-group">
    <h6>
        <label>Khuyến mãi:</label>
    </h6>
    <textarea name="promotion" class="form-control content-tiny" rows="10">{{ $product->promotion }}</textarea>
    @error('promotion')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
