<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'=>['nullable','string'],
            'last_name'=>['nullable','string'],
            'username'=>['nullable','string','unique:users,username,'.auth()->id().',id'],
            'email'=>['nullable','string','unique:users,email,'.auth()->id().',id'],
        ];

        return $rules;
    }
}
