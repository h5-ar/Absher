<?php

namespace App\Http\Requests;

use App\Helpers\GeneralHelpers\Response;
use App\Models\ProductStock;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items.sku.*'     => ['required', 'string'],
            'items.qty.*'     => ['required', 'integer'],
            'coupon'          => ['nullable', 'string', 'exists:coupons,code'],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        $sku = collect($this->items)->pluck('sku')->unique()->toArray();
        return [
            function (Validator $validator) use ($sku) {

                if (ProductStock::whereIn('sku', $sku)->get(['id', 'sku'])->unique('sku')->count() != count($sku)) {
                    $validator->errors()->add(
                        'items',
                        translate('Invalid selected products')
                    );
                }
            }
        ];
    }

    public function passedValidation(): void
    {
        $items = request()['items'];
        $skus = collect($items)->pluck('sku');

        if (count($skus) != count(array_unique($skus->toArray()))) {
            abort(message: "Duplicated Items", code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $offers = request()['offers'];
        $ids = collect($offers)->pluck('id');

        if (count($ids) != count(array_unique($ids->toArray()))) {
            abort(message: "Duplicated Offers", code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
