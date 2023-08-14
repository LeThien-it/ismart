<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'position' => 'required',
            'cat_pro_id' => 'required',
            'image_path' => 'required|mimes:jpg,png,gif,jpeg,webp|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tiêu đề slider',
            'position.required' => 'Chọn vị trí slider',
            'cat_pro_id.required' => 'Chọn danh mục slider',
            'image_path.required' => 'Chọn ảnh slider',
            'image_path.mimes' => 'Ảnh phải thuộc định dạng jpg,png,gif,jpeg,webp',
            'image_path.max' => 'Kích thước ảnh tối đa 10000KB',
        ];
    }
}
