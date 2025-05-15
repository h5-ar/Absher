<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        if (Route::is('api.verification.check')) {
            $rules = [
                'phone_number'      => ['required', 'numeric', 'digits_between:10,12'],
                'code'          => ['required', 'numeric', 'digits:4']
            ];
        } elseif (Route::is('api.login')) {
            $rules = [
                'phone_number'      => ['required', 'numeric', 'digits_between:10,12'],
            ];
        } elseif (Route::is('dashboard.login.submit')) {
            $rules = [
                'username'          => ['required', 'string'],
                'password'          => ['required', 'string', 'min:8']
            ];
        }
        return $rules;
    }
}
