<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantUpdateRequest extends FormRequest
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
            'price' => 'required',
            'quantity' => 'required',
            'attribute_value_id' => 'required',
            'feature_image_path' => 'mimes:jpg,png,gif,jpeg,webp|max:10000',
            "image_path"    => [
                'array', 
            ],
            "image_path.*"  => [
                'mimes:jpg,png,gif,jpeg,webp',
            ],
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Chọn tên sản phẩm ',
            'feature_image_path.required' => 'Chọn ảnh đại diện',
            'price.required' => 'Nhập giá sản phẩm',
            'quantity.required' => 'Nhập số lượng sản phẩm',
            'feature_image_path.mimes' => 'Ảnh phải thuộc định dạng jpeg,jpg,png,gif,webp',
            'image_path.mimes' => 'Ảnh phải thuộc định dạng jpeg,jpg,png,gif,webp',
            'attribute_value_id.required' => 'Chọn một trong các thuộc tính cần thiết',
        ];
    }
}
