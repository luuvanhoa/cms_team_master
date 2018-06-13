<?php

namespace App\Http\Requests;

class PostRequest extends Request
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
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:30'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.string' => 'Tiêu đề bài viết phải là một chuỗi',
            'title.min' => 'Tiêu đề bài viết quá ngắn (từ 3 đến 255 ký tự)',
            'title.max' => 'Tiêu đề bài viết quá dài (từ 3 đến 255 ký tự)',
            'content.required' => 'Nội dung bài viết không được rỗng.',
            'content.min' => 'Nội dung bài viết quá ngắn (Lớn hơn 3 ký tự)',
            'content.string' => 'Nội dung bài viết phải là một chuỗi'
        ];
    }
}
