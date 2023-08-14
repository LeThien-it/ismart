<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'name' => 'required|min:3|unique:pages,name,'.$this->id.'',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn hãy nhập tên trang',
            'name.unique' => 'Tên trang đã tồn tại trên hệ thống',
            'content.required' => 'Bạn hãy nhập nội dung trang ',
        ];
    }
}
