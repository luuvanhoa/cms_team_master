<?php

namespace App\Http\Requests;

class ProductRequest extends Request
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
            'name' => 'required|string|min:3|max:255',
            'image' => 'required|image|max:8000|mimes:jpeg,jpg,png',
            'slug' => 'required|string|min:3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.min' => 'Tên sản phẩm quá ngắn (từ 3 đến 255 ký tự)',
            'name.max' => 'Tên sản phẩm quá dài (từ 3 đến 255 ký tự)',
            'image.required' => 'Bạn chưa chọn hình ảnh cho sản phẩm',
            'image.max' => 'Hình ảnh tải lên quá lớn.',
            'image.image' => 'Dữ liệu tải lên không phải là hình ảnh',
            'image.mimes' => 'Hình ảnh tải lên không đúng định dạng (định dạng cho phép: jpeg,jpg,png)',
            'slug.required' => 'Đường dẫn chưa được nhập.',
            'slug.min' => 'Đường dẫn quá ngắn (Lớn hơn 3 ký tự)',
            'slug.string' => 'Đường dẫn phải là một chuỗi'
        ];
    }
}
