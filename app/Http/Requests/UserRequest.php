<?php

namespace App\Http\Requests;

use App\Enums\UserGender;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'username'      => ['nullable', 'string', 'max:200', Rule::unique('users')->ignore(request()->route('id'))],
            'name'          => ['nullable', 'string', 'max:200'],
            'last_name'     => ['nullable', 'string', 'max:200'],
            'password'      => ['nullable', 'string', 'max:50'],
            'join_code'     => ['nullable', 'string'],
            'email'         => ['nullable', Rule::unique('users', 'email')->ignore(request()->route('id')), 'email', 'max:200'],
            'phone_number'  => ['nullable', Rule::unique('users', 'phone_number')->ignore(request()->route('id')), 'numeric', 'digits:10', 'starts_with:09'],
            'gender'        => ['nullable', Rule::in(UserGender::casesValue())],
            'birth_date'    => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'profile'       => ['nullable', 'image'],
        ];

        return $rules;
    }
}
