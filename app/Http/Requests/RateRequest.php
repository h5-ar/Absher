<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            'image'          => ['nullable', 'image'],
            'comment'        => ['nullable', 'string',],
            'product_id'     => ['required', 'string', 'exists:products,id'],
            'rate'           => ['required', 'integer', 'min:0', 'max:5'],
            'images'         => ['nullable', 'array', 'max:3'],
            'images.*'       => ['nullable', 'image', File::image()->max('5mb')]
        ];
        if(Route::is('api.rates.update'))
        {
            unset($rules['product_id']);
        }

        return $rules;
    }
}
