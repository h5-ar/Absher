<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class BecomeSellerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules= [
            'email'              =>['required','string',Rule::unique('users')->ignore(auth()->check()?auth()->id():null)],
            'username'           =>['required','string',Rule::unique('users')->ignore(auth()->check()?auth()->id():null)],
            'phone_number'       =>['required','string','starts_with:09'],
            'address'            =>['required','string'],
        ];

        return $rules;
    }
}
