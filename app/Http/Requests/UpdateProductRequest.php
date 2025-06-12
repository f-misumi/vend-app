<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'exists:companies,id'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'img_path' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須です。',
            'company_id.required' => 'メーカーを選択してください。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格は整数で入力してください。',
            'stock.required' => '在庫数は必須です。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
            'img_path.image' => '画像ファイルを指定してください。',
            'img_path.max' => '画像のサイズは2MB以下でなければなりません。',
        ];
    }
}
