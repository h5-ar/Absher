<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Enums\UserGender;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'      => ['nullable', 'string', 'max:200', Rule::unique('users')->ignore(request()->route('id'))],
            'name'          => ['nullable', 'string', 'max:200'],
            'last_name'     => ['nullable', 'string', 'max:200'],
            'password'      => ['nullable', 'string', 'max:50'],
            'email'         => ['nullable', Rule::unique('users', 'email')->ignore(request()->route('id')), 'email', 'max:200'],
            'phone_number'  => ['nullable', Rule::unique('users', 'phone_number')->ignore(request()->route('id')), 'numeric', 'digits:10', 'starts_with:09'],
            'gender'        => ['nullable', Rule::in(UserGender::casesValue())],
            'roles'         => ['required', 'array'],
            'roles.*'       => ['required', 'string', 'exists:roles,name'],
            'birth_date'    => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
        ];
    }
}
