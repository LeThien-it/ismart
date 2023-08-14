<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
            'attribute_id' => 'required',
            'value' => 'required|unique:attribute_values,value,' . $this->id . '',
        ];
    }

    public function messages()
    {
        return [
            'attribute_id.required' => 'Bạn hãy chọn thuộc tính',
            'value.required' => 'Nhập giá trị thuộc tính',
            'value.unique' => 'Giá trị này đã tồn tại trong hệ thống',
        ];
    }

}
