<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Doctor;
use Illuminate\Validation\Rules;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Admin is authorized via middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (str_word_count($value) < 2) {
                    $fail('The ' . $attribute . ' field must contain at least first and last names.');
                }
            }],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Doctor::class],
            'password' => ['required', 'confirmed'], 
            'specialty_id' => ['required', 'exists:specialties,id'],
            'phone' => ['required', 'string', 'unique:'.Doctor::class, 'regex:/^01[0125][0-9]{8}$/'],
            'gender' => ['required', 'in:male,female'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number must be a valid Egyptian phone number (e.g., 01xxxxxxxxx).',
        ];
    }
}
