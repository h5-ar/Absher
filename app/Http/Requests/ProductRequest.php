<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {


        if ($this->has('recoverable') && $this->recoverable == 'on') {
            $this->merge([
                'recoverable' => true,
            ]);
        } else {
            $this->merge([
                'recoverable' => false,
            ]);
        }
        if ($this->has('recommended') && $this->recommended == 'on') {
            $this->merge([
                'recommended' => true,
            ]);
        } else {
            $this->merge([
                'recommended' => false,
            ]);
        }
        if ($this->has('flash_deal') && $this->flash_deal == 'on') {
            $this->merge([
                'flash_deal' => true,
            ]);
        } else {
            $this->merge([
                'flash_deal' => false,
            ]);
        }
        if ($this->has('free_delivery') && $this->free_delivery == 'on') {
            $this->merge([
                'free_delivery' => true,
            ]);
        } else {
            $this->merge([
                'free_delivery' => false,
            ]);
        }
        if ($this->has('published') && $this->published == 'on') {
            $this->merge([
                'published' => true,
            ]);
        } else {
            $this->merge([
                'published' => false,
            ]);
        }
        $this->merge(['category_id' => $this->sub_category_id]);
    }

    public function rules(): array
    {

        $rules = [
            'name'                                      => ['required', 'string', 'max:200'],
            'name_ar'                                   => ['required', 'string', 'max:200'],
            'category_id'                               => ['required', 'string', 'max:200'],
            'brand_id'                                  => ['required', 'string', 'max:200'],
            'tags'                                      => ['required', 'array',],
            'unit'                                      => ['nullable', 'string', Rule::in(['g', 'kg', 'l', 'ml'])],
            'description'                               => ['nullable', 'string',],
            'description_ar'                            => ['nullable', 'string',],
            'min_quantity'                              => ['required', 'integer'],
            'max_quantity'                              => ['required', 'integer'],
            'min_order'                                 => ['required', 'integer'],
            'max_order'                                 => ['required', 'integer'],
            'recovery_duration'                         => ['required_if:recoverable,true', 'nullable', 'integer'], //Number Of Days
            'recoverable'                               => ['required', 'boolean'],
            'recommended'                               => ['required', 'boolean'],
            'free_delivery'                             => ['required', 'boolean'],
            'published'                                 => ['required', 'boolean'],
            'flash_deal'                                => ['required', 'boolean'],
            'main_discount_type'                        => ['required', 'string', Rule::in(['discount', 'percentage'])],
            'main_discount_value'                       => ['required', 'integer'],
            'colors'                                    => ['nullable', 'array'],
            'imageId'                                   => ['required', 'string'],
            'attributes'                                => ['nullable', 'array'],
            'sizes'                                     => ['nullable', 'array'],
            'fabrics'                                   => ['nullable', 'array'],
            'variants'                                  => ['nullable', 'array'],
            'variants.*.sku'                            => ['required', 'unique:product_stocks,sku'],
            'variants.*.price'                          => ['required', 'decimal:0,4'],
            'variants.*.images'                         => ['required'],
            'variants.*.sellers'                        => ['required', 'array'],
            'variants.*.sellers.*.seller_id'            => ['required',],
            'variants.*.sellers.*.qty'                  => ['required', 'integer'],
            'variants.*.sellers.*.purchase_price'       => ['required', 'decimal:0,4'],
        ];
        if (Route::is('dashboard.products.update')) {
            unset($rules['main_discount_type']);
            unset($rules['main_discount_value']);
            $rules['variants.*.discount_type'] = ['required', 'string', Rule::in(['discount', 'percentage'])];
            $rules['variants.*.discount_value'] = ['required', 'integer'];
            $rules['variants.*.sku'] = ['required', 'unique:product_stocks,sku,' . request()->route('id') . ',product_id'];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'unit.in' => 'The selected unit is invalid ,the valid units are:kg,g,l,ml',
        ];
    }
}
