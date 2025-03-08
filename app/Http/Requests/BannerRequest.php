<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        if (Route::is('dashboard.banners.store')) {
            $rules=[
                'name'=>        ['required','string' ],
                'name_ar'=>     ['required','string' ],
                'type'=>        ['required', 'in:category,product,brand'],
                'start_date'=>  ['required', 'date', 'after:yesterday'],
                'end_date'=>    ['required', 'date', 'after:start_date'],
                'imageId'=>     ['required','string','exists:uploads,id' ],

            ];
        }
        elseif (Route::is('dashboard.banners.update')) {
            $rules=[
                'name'=>        ['nullable','string' ],
                'name_ar'=>     ['nullable','string' ],
                'type'=>        ['nullable','in:category,product,brand'],
                'start_date'=>  ['nullable','date', 'after:yesterday'],
                'end_date'=>    ['nullable','date', 'after:start_date'],
                'imageId'=>     ['nullable','string','exists:uploads,id' ],
            ];
        }
        return $rules;
    }
}
