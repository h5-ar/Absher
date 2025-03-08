<?php

namespace App\Http\Requests;

use App\Enums\OfferType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class OfferRequest extends FormRequest
{

    public function prepareForValidation()
    {
        if (request()->is_active == "on") {
            request()->merge(['is_active' => true]);
        } else {
            request()->merge(['is_active' => false]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'name'              => ['string'],
            'name_ar'           => ['string'],
            'type'              => [Rule::in(OfferType::casesValue())],
            'is_active'         => ['boolean'],
            'imageId'           => ['required', 'string', 'exists:uploads,id'],
            'start_date'        => ['date', 'after_or_equal:tody'],
            'end_date'          => ['date', 'after:start_date'],
            'value'             => ['required_unless:type,gift', 'numeric', 'min:0'],
            'items'             => ['array'],
            'items.*.quantity'  => ['integer', 'min:1'],
            'items.*.stock_id'  => ['string', 'exists:product_stocks,id'],
            'gifts'             => ['required_if:type,gift', 'array'],
            'gifts.*.quantity'  => ['integer', 'min:1'],
            'gifts.*.stock_id'  => ['string', 'exists:product_stocks,id'],
        ];

        if (Route::is('dashboard.offers.store')) {
            foreach ($rules as $key => $rule) {
                if (!in_array($key, ['value', 'gifts', 'is_active', 'start_date', 'end_date'])) {
                    $rules[$key] = ['required', ...$rule];
                } else if (in_array($key, ['start_date', 'end_date'])) {
                    $rules[$key] = ['nullable', ...$rule];
                }
            }
            return $rules;
        }
    }
}
