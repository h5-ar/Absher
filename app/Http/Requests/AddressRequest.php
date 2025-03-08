<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'          => ['required', 'string'],
            'line_one'      => ['nullable', 'string'],
            'line_two'      => ['nullable', 'string'],
            'description'   => ['required', 'string'],
            'city'          => ['required', 'string'],
            'phone'         => ['required', 'numeric'],
            'long'      => ['nullable', 'numeric', 'between:-90,90'],
            'lat'     => ['nullable', 'numeric', 'between:-180,180']
        ];

        return $rules;
    }
}
