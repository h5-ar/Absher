<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = [];
        $offers = [];
        foreach ($this->orderItems as $item) {
            if (isset($item->offer_id)) {
                if (!array_key_exists($item->offer_id, $offers)) {
                    $offers[$item->offer_id] = [
                        'name'           => $item->offer->name,
                        'discountType'   => strtolower($item->offer->type->name),
                        'discountValue'  => $item->offer->value,
                        'price'  => 0,
                        'items'  => [],
                        'gifts'  => [],
                    ];
                }
                $itemInfo = [
                    'id'          => $item->id,
                    'stock_id'    => $item->stock_id,
                    'product_id'  => $item->stock->product_id,
                    'name'        => $item->stock->product->name,
                    'description' => $item->stock->product->description,
                    'quantity'    => $item->product_quantity,
                    'color'       => $item->stock->variant['color'] ?? null,
                    'size'        => $item->stock->variant['size'] ?? null,
                    'image'       => asset($item->stock->attache->upload->url),
                ];


                if ($item->is_gift) {
                    $offers[$item->offer_id]['gifts'][] = $itemInfo;
                } else {
                    $offers[$item->offer_id]['price'] += $item->price;
                    $offers[$item->offer_id]['items'][] = $itemInfo;
                }
            } else {
                $items[] = [
                    'id'                           => $item->id,
                    'product_id'                   => $item->stock->product_id,
                    'price'                        => $item->price,
                    'price_after_discount'         => $item->price - (calcDiscount($item->unit_price, $item->discount_type, $item->discount_value) * $item->product_quantity),
                    'name'                         => $item->stock->product->name,
                    'description'                  => $item->stock->product->description,
                    'color'                        => $item->stock->variant['color'] ?? null,
                    'size'                         => $item->stock->variant['size'] ?? null,
                    'quantity'                     => $item->product_quantity,
                    'image'                        => asset($item->stock->attache->upload->url),
                ];
            }
        }
        foreach ($offers as &$offer) {

            $priceAfterDiscount = $offer['price'] - calcDiscount($offer['price'], $offer['discountType'], $offer['discountValue']);
            $offer['price'] = $priceAfterDiscount;


            unset($offer['discountType'], $offer['discountValue']);
        }

        $settings = Setting::whereIn('key', ['Store Name', 'Nazik Email', 'Nazik Phone Number', 'Nazik Address'])->get();
        $price = ($this->total_price + $this->shipping_cost + $this->tax) - $this->discount;
        return [
            'order_id'  => $this->id,
            'order_number' => $this->order_number,
            'order_status'  => $this->status,
            'shipping_cost'  => $this->shipping_cost,
            'tax'  => $this->tax,
            'payment_gateway' => 'Cash',
            'price' => $price,
            'price_after_coupon' => ($price - calcDiscount($price, strtolower($this->coupon?->discount_type->name), $this->coupon?->discount_value)),
            'coupon' => $this?->coupon?->code,
            'user'  => [
                'name' => $this->user->fullName,
                'email' => $this->user->email,
                'phone_number' => $this->user->phone_number,
                'address'   => ['city' => $this->address['city'] ?? '', 'description' => $this->address['description'] ?? '']
            ],
            'seller'  => [
                'name' => $settings->where('key', 'Store Name')->first()->value,
                'email' => $settings->where('key', 'Nazik Email')->first()->value,
                'phone_number' => $settings->where('key', 'Nazik Phone Number')->first()->value,
                'address'   => $settings->where('key', 'Nazik Address')->first()->value,
            ],
            'items' => $items,
            'offers' => $offers,
        ];
    }
}
