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
        $data = [
            'chat_id' => ['required' , 'exists:chats,id'],
            'type' => ['required' , 'in:text,image,video,audio'],
        ];

        $type = $this->input('type');

        if($type === "text"){
            $data['content'] = ['required' , 'string','max:255'];
        }

        if($type === "image"){
            $data['content'] = ['required' , 'file' , 'max:2048' , 'mimes:jpg,jpeg,png'];
        }
        if ($type === "video"){
            $data['content'] = ['required' , 'file' , 'max:2048' , 'mimes:mp4'];
        }
        if ($type === "audio"){
            $data['content'] = ['required' , 'file' , 'max:2048' , 'mimes:mp3'];
        }
        return $data;
    }
}
