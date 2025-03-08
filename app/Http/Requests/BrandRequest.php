<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'meta_title'        => ['nullable', 'string'],
            'meta_description'  => ['nullable', 'string'],
        ];
        if (Route::is('dashboard.brands.store')) {
            $rules['name']      = ['required', 'string', 'unique:brands,name'];
            $rules['name_ar']      = ['required', 'string',];
            $rules['imageId']   = ['required', 'string', 'exists:uploads,id'];
        } elseif (Route::is('dashboard.brands.update')) {
            $rules['name']          = ['required', 'string', 'unique:brands,name,' . request()->route('id') . ',id'];
            $rules['name_ar']       = ['nullable', 'string'];
            $rules['imageId']       = ['nullable', 'string', 'exists:uploads,id'];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'imageId.*' => 'مطلوب إدخال الصورة'
        ];
    }
}
