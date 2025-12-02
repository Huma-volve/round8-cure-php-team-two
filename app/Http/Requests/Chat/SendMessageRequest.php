<?php

namespace App\Http\Requests\Chat;

use App\Enums\MessageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => ['required' , 'exists:chats,id'],
            'type' => ['required' , new Enum(MessageType::class)],
            'content' => ['nullable' , 'string','max:255'],
            'file' => ['nullable' , 'file' , 'max:2048'],
        ];
    }
}
