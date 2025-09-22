<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'condition' => ['required', 'in:new,like_new,used'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => '商品名は必須です',
            'price.required' => '販売価格は必須です',
            'condition.required' => '商品の状態を選択してください',
            'categories.required' => 'カテゴリは1つ以上選択してください',
        ];
    }
    
    
}
