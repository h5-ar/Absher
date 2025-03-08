<?php

namespace App\Http\Requests;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Rules\UniqueCoupon;
use App\Enums\CouponableType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;


class CouponRequest extends FormRequest
{

    public function prepareForValidation(): void
    {
        request()->merge(['type' => CouponType::matchEnum(request()->type)->value]);
    }
    public function rules(): array
    {
        $ignore = Route::is('dashboard.coupons.update') ? request()?->route('coupon')?->id : false;

        return [
            'name'                  => ['required', 'string', new UniqueCoupon(ignore: $ignore)],
            'code'                  => ['required', 'string',  new UniqueCoupon(ignore: $ignore), 'max:15', 'min:6'],
            'start_date'            => ['nullable', 'date', 'after:yesterday', 'before:end_date'],
            'end_date'              => ['nullable', 'date', 'after:start_date'],
            'discount_type'         => ['required', Rule::in(DiscountType::cases())],
            'discount_value'        => ['required', 'integer', Rule::when(request()->discount_type == DiscountType::PERCENTAGE->value, ['max:100', 'min:0'], ['min:0']),],
            'type'                  => ['required', Rule::in(CouponType::casesValue())],
            'on'                    => ['required', Rule::in(CouponableType::casesValue())],
            'times'                 => ['nullable', 'integer', 'min:1'],
            'users'                 => [Rule::requiredIf(request()->type == CouponType::PRIVATE->value), 'array'],
        ];
    }
}
