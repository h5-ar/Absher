<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\VarianceResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $rate_avg = null;
        $accepted_stocks = [];

        if (isset($this->accepted_stocks)) {
            $accepted_stocks = VarianceResource::collection($this->accepted_stocks);
        } elseif ($this->RelationLoaded('stocks')) {
            $accepted_stocks = VarianceResource::collection($this->stocks);
        }

        if ($this->RelationLoaded('rateAvg')) {
            $rate_avg = round($this->rateAvg->first()?->rate_avg, 2);
        }

        $isAuthenticated = auth()->check();
        if ($isAuthenticated) {
            $this->load('isWishlist');
        }
        $this->load('attache');

        return [
            'id'                 => $this->id,
            'name'               => getTranslation($this->resource, 'name'),
            'description'        => getTranslation($this->resource, 'description'),
            'recoverable'        => $this->recoverable,
            'recovery_duration'  => $this->recovery_duration,
            'free_delivery'      => $this->free_delivery,
            'tags'               => $this->tags,
            'unit'               => $this->unit,
            'flash_deal'         => $this->flash_deal,
            'min_quantity'       => $this->min_quantity,
            'max_quantity'       => $this->max_quantity,
            'min_order'          => $this->min_order,
            'max_order'          => $this->max_order,
            'view_count'         => (int) $this->view_count,
            'variances'          => $this->attributes,
            'image'              => asset($this->attache?->upload?->url),
            'rate_avg'           => $this->when($rate_avg  !== null, $rate_avg),
            'rates'              => RateResource::collection($this->whenLoaded('rates')),
            'category'           => CategoryResource::make($this->whenLoaded('category')),
            'brand'              => BrandResource::make($this->whenLoaded('brand')),
            'variant'            => VarianceResource::make($this->whenLoaded('firstStock')),
            'is_wishlist'        => $isAuthenticated ? isset($this->isWishlist) : false,
            'variants'           => $this->when($accepted_stocks, $accepted_stocks),
            // 'orders_count'       => $this->when(, $this->orders_count)
        ];
    }
}
