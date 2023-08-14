<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users|regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập họ và tên',
            'name.max' => 'Họ và tên không dài quá 255 ký tự',
            'email.required' => 'Nhập email',
            'email.email' => 'Email chưa đúng định dạng',
            'email.max' => 'Email không dài quá 255 ký tự',
            'email.unique' => 'email đã được sử dụng. Hãy thử tên khác.',
            'email.regex' => 'email phải nằm trong khoảng từ 6-32 kí tự',
            'password.required' => 'nhập mật khẩu',
            'password.confirmed' => 'Các mật khẩu đã nhập không khớp. Hãy thử lại.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'role_id.required' => 'Chọn nhóm quyền cho thành viên',
        ];
    }
}
