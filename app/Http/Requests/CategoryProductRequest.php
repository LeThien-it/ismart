<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryProductRequest extends FormRequest
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
            // 'name' => 'required|unique:category_products,name,' . $this->id . '',
            // 'name' => Rule::unique('category_products')->where(function ($query) {
            //     return $query->where('parent_id', $this->parent_id);
            // })->ignore($this->id),
            'name' => [
                'required',
                Rule::unique('category_products')->where(function ($query) {
                    return $query->where('parent_id', $this->parent_id);
                })->ignore($this->id)
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên danh mục',
            'name.unique' => 'Danh mục đã tồn tại',
        ];
    }
}
