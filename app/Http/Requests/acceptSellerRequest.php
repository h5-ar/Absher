<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class acceptSellerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules= [
            'long' =>['nullable','string'],
            'lat' =>['nullable','string'],
            'city' =>['nullable','string'],
            'street' =>['nullable','string'],
            'description' =>['nullable','string'],
            // 'verified' =>['nullable','boolean'],
            'active' =>['nullable','boolean'],
            'cash' =>['nullable','string'],
            'bank_name' =>['nullable','string'],
            'account_number' =>['nullable','string'],
        ];
        return $rules;
    }
}
