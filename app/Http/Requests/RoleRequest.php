<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,' . $this->id . '',
            'desc' => 'required',
            'permission_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên nhóm quyền ',
            'name.unique' => 'Tên nhóm quyền đã tồn tại',
            'desc.required' => 'Nhập mô tả nhóm quyền',
            'permission_id.required' => 'Chọn quyền',
        ];
    }
}
