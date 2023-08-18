<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|unique:products,name,' . $this->id . '',
            'content' => 'required',
            'warranty' => 'required',
            'promotion' => 'required',
            'parameter' => 'required',
            'parameter_detail' => 'required',
            'category_product_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại trên hệ thống',
            'content.required' => 'Nhập thông tin sản phẩm',
            'warranty.required' => 'Nhập nội dung bảo hành',
            'promotion.required' => 'Nhập nội dung khuyến mãi',
            'parameter.required' => 'Nhập cấu hình sản phẩm',
            'parameter_detail.required' => 'Nhập thông số kỹ thuật',
            'category_product_id.required' => 'Chọn danh mục sản phẩm ',
        ];
    }
}
