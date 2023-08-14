<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'password' => 'min:8|confirmed',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập họ và tên',
            'name.max' => 'Họ và tên không dài quá 255 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Các mật khẩu đã nhập không khớp. Hãy thử lại.',
            'role_id.required' => 'Chọn nhóm quyền cho thành viên',
        ];
    }
}
