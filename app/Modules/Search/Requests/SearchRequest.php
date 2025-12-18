<?php

namespace App\Modules\Search\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'يجب إدخال كلمة البحث',
            'content.string' => 'كلمة البحث يجب أن تكون نصًا',
            'content.max' => 'كلمة البحث يجب ألا تتجاوز 255 حرفًا',
        ];
    }
}
