<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VersionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'version'        => ['required', 'string'],
            'url'            => ['required', 'string',],
            'currency'       => ['required', 'string',],
            'published'      => ['required', 'string',],
            'platform'       => ['required', 'string', 'in:android,ios'],
        ];
        if (Route::is('versions.update')) {
            $rules = [
                'version'        => ['nullable', 'string'],
                'url'            => ['nullable', 'string',],
                'currency'       => ['nullable', 'string',],
                'published'      => ['nullable', 'string',],
                'platform'       => ['nullable', 'string', 'in:android,ios'],
            ];
        }
        return $rules;
    }
}
