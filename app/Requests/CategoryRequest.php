<?php

namespace App\Http\Requests;

class CategoryRequest extends Request
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
            'name' => 'required|min:3|max:255',
            // 'image'     => 'required|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.min' => 'Tên danh mục quá ngắn (từ 3 đến 255 ký tự)',
            'name.max' => 'Tên danh mục quá dài (từ 3 đến 255 ký tự)'
        ];
    }
}
