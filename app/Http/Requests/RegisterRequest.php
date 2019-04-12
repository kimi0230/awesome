<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|min:6|max:20',
            'password' => 'required|min:6|max:20',
            'email' => 'required|email',
        ];
    }
    public function messages()
    {
        return [
            'username.required' => '請輸入姓名',
            'password.required' => '請輸入密碼',
            'mobile.required' => '請輸入電話',
            'email.required' => '需輸入電子信箱',
            'email' => '信箱格式錯誤',
        ];
    }
}
