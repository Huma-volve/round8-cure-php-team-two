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
        $data = [
            'chat_id' => ['required' , 'exists:chats,id'],
            'type' => ['required' , new Enum(MessageType::class)],
        ];

        if('type' === MessageType::TEXT){
            $data['content'] = ['required' , 'string','max:255'];
        }

        if('type' === MessageType::IMAGE){
            $data['file'] = ['required' , 'file' , 'max:2048' , 'mimes:jpg,jpeg,png'];
        }
        if ('type' === MessageType::VIDEO){
            $data['file'] = ['required' , 'file' , 'max:2048' , 'mimes:mp4'];
        }
        if('type' === MessageType::AUDIO){
            $data['file'] = ['required' , 'file' , 'max:2048' , 'mimes:mp3'];
        }
        return $data;
    }
}
