<?php

namespace App\Http\Requests;

class LoginAdminRquest extends Request
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
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'email.required' => 'Vui lòng nhập vào email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập vào mật khẩu',
        ];
    }
}
