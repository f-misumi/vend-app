<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^[\x21-\x7E]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名は必須項目です。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '有効なメールアドレス形式で入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
            'password.regex' => 'パスワードは半角英数字および記号で入力してください。',
        ];
    }
}
