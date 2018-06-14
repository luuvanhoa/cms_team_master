<?php

namespace App\Http\Requests;

class BannerRequest extends Request
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
            'title' => 'required|min:3',
            'image' => 'required|image|max:8000|mimes:jpeg,jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập vào tiêu đề',
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.mimes' => 'Vui lòng chọn hình ảnh có phần mở rộng hợp lệ (*.jpeg,*.jpg,*.png)'
        ];
    }
}
