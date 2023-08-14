<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|min:3|unique:posts,title,'.$this->id.'',
            'post_image_path' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'desc' => 'required',
            'content' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Bạn hãy nhập tiêu đề',
            'title.min' => 'Tiêu đề không được ít hơn 3 kí tự',
            'title.unique' => 'Tiêu đề đã tồn tại trên hệ thống',
            'post_image_path.required' => 'Cần chọn hình ảnh',
            'post_image_path.mimes' => 'Hình ảnh phải là định dạng : jpeg,png,jpg,gif,svg,webp',
            'post_image_path.max' => 'Hình ảnh không được lớn hơn 2048KB',
            'desc.required' => 'Bạn hãy nhập mô tả ngắn cho bài viết ',
            'content.required' => 'Bạn hãy nhập nội dung bài viết ',
            'category_id.required' => 'Bạn hãy chọn danh mục bài viết '
        ];
    }
}
