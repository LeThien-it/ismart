<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantAddRequest extends FormRequest
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
            'product_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'attribute_value_id' => 'required',
            'feature_image_path' => 'required|mimes:jpg,png,gif,jpeg,webp',
            'image_path' => ['required', 'array'],
            'image_path.*' => ['required', 'mimes:jpg,png,gif,jpeg,webp'],
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Chọn tên sản phẩm ',
            
            'price.required' => 'Nhập giá sản phẩm',
            'price.numeric' => 'Giá trị nhập vào phải là số',
            
            'quantity.required' => 'Nhập số lượng sản phẩm',
            'quantity.numeric' => 'Giá trị nhập vào phải là số',

            'feature_image_path.required' => 'Chọn ảnh đại diện',
            'feature_image_path.mimes' => 'Ảnh phải thuộc định dạng jpg,png,gif,jpeg,webp',
            
            'image_path.required' => 'Chọn ảnh chi tiết',
            'image_path.*.mimes' => 'Ảnh phải thuộc định dạng jpg,png,gif,jpeg,webp',
            
            'attribute_value_id.required' => 'Chọn một trong các thuộc tính cần thiết',
        ];
    }
}
