<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'email' => ['required', 'email', 'max:255', 'unique:users', 'email'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:20', 'unique:users,username'],
            'password' => ['required', 'min:8','confirmed'],
            'description' => ['required', 'string'],
            'manager' => ['required', 'exists:managers,id'],




        ];
    }
}
