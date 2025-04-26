<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id'); // تأكد أن اسم المعلمة في الرابط هو 'user' (أو غيّره حسب مسارك)
        
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'username' => [
                'required',
                'alpha_num',
                'min:3',
                'max:20',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => ['sometimes', 'min:8', 'max:100', 'confirmed']
        ];
    }
}