<?php

namespace App\Http\Requests\Chat;

use App\Enums\MessageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SendMessageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'chat_id' => ['required', 'exists:chats,id'],
            'type' => ['required', 'in:text,image,video,audio'],
            'content' => ['required'],
        ];

        $type = $this->input('type');

        if ($type === "text") {
            $rules['content'] = ['required', 'string', 'max:500', 'min:1'];
        }

        if ($type === "image") {
            $rules['content'] = ['required', 'file', 'max:2048', 'mimes:jpg,jpeg,png,gif'];
        }
        
        if ($type === "video") {
            $rules['content'] = ['required', 'file', 'max:20000', 'mimes:mp4,avi,mov,mkv'];
        }
        
        if ($type === "audio") {
            $rules['content'] = ['required', 'file', 'max:10000', 'mimes:mp3,wav,m4a,aac'];
        }
        
        return $rules;
    }
    
    public function messages(): array
    {
        return [
            'chat_id.required' => 'Chat ID is required',
            'chat_id.exists' => 'Chat not found',
            'type.required' => 'Message type is required',
            'type.in' => 'Invalid message type',
            'content.required' => 'Message content is required',
            'content.string' => 'Message must be text',
            'content.max' => 'Message is too long (max 500 characters)',
            'content.min' => 'Message cannot be empty',
            'content.file' => 'Please select a valid file',
            'content.mimes' => 'File format is not supported',
        ];
    }
}
