<div class="form-group mt-3">
    <label for="">Cấu hình sản phẩm</label>
    <textarea name="parameter" class="form-control content-tiny"  cols="30" rows="15">{{ old('parameter') }}</textarea>
    @error('parameter')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="tinymce">Thông số kỹ thuật</label>
    <textarea name="parameter_detail" class="form-control content-tiny" id="tinymce" cols="30" rows="15">{{ old('parameter_detail') }}</textarea>
    @error('parameter_detail')
        <div class="text-danger">
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>

