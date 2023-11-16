<div class="form-group mt-3">
    <h6>
        <label>Cấu hình sản phẩm:</label>
    </h6>
    <textarea name="parameter" class="form-control content-tiny" cols="30" rows="15">{{ old('parameter') }}</textarea>
    @error('parameter')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

<div class="form-group">
    <h6>
        <label>Thông số kỹ thuật:</label>
    </h6>
    <textarea name="parameter_detail" class="form-control content-tiny" cols="30" rows="15">{{ old('parameter_detail') }}</textarea>
    @error('parameter_detail')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
