<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    public function rules(): array
    {
        return $rules = [
            'name'     => ['required', 'string'],
            'lang'     => ['required', 'string', 'in:arabic,english'],
            'content'  => ['required', 'string'],
        ];
    }
}
