<?php

namespace App\Http\Requests;

use App\Rules\SubCategoryRule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'meta_title'                => ['nullable', 'string'],
            'meta_description'          => ['nullable', 'string'],
            'subCategories'             => ['nullable', 'array', new SubCategoryRule()],
            'gender'                    => ['required', 'in:1,2,3,4'],
        ];

        if (Route::is('dashboard.categories.store')) {
            $rules['name']              = ['required', 'string', 'unique:categories,name'];
            $rules['imageId']           = ['required', 'string', 'exists:uploads,id'];
        } elseif (Route::is('dashboard.categories.update')) {
            $rules['imageId']           = ['nullable', 'string', 'exists:uploads,id'];
            $rules['name']              = ['nullable', 'string', 'unique:categories,name,' . request()->route('id') . ',id'];
            $rules['subCategories']     = ['nullable', 'array', new SubCategoryRule()];
        }

        return $rules;
    }
}
