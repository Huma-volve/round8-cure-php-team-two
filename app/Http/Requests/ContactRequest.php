<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Name is required',
            'email.required'   => 'Email is required',
            'email.email'      => 'Email must be valid',
            'message.required' => 'Message is required',
        ];
    }
}
