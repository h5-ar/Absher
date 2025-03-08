<?php

namespace App\Http\Requests;

use App\Enums\UserGender;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'username'      => ['nullable', 'string', 'max:200', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null)],
            'name'          => ['required', 'string', 'max:200'],
            'last_name'     => ['required', 'string', 'max:200'],
            'password'      => ['nullable', 'string', 'max:50'],
            'email'         => ['nullable', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null), 'email', 'max:200'],
            'join_code'     => ['nullable', 'string', 'exists:users,join_code'],
            'phone_number'  => ['required', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null), 'numeric', 'digits_between:10,12'],
            'gender'        => ['nullable', Rule::in(UserGender::casesValue())],
            'birth_date'    => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
        ];

        if (Route::is('api.profile.update')) {
            $rules =  [
                'username'      => ['nullable', 'string', 'max:200', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null)],
                'name'          => ['nullable', 'string', 'max:200'],
                'last_name'     => ['nullable', 'string', 'max:200'],
                'email'         => ['nullable', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null), 'email', 'max:200'],
                'join_code'     => ['nullable', 'string', 'exists:users,join_code'],
                'phone_number'  => ['nullable', Rule::unique('users')->ignore(auth('api')->check() ? auth('api')->id() : null), 'numeric', 'digits:10', 'starts_with:09'],
                'gender'        => ['nullable', Rule::in(UserGender::casesValue())],
                'birth_date'    => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
                'image'         => ['nullable', 'image']
            ];
        }
        return $rules;
    }
}
