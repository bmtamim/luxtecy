<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'type'                => $this->type,
            'details'             => Str::replace('currency', 'hi', 'Get [currency]10 Delivery fees discount.'),
            'amount'              => $this->amount,
            'max_discount_amount' => $this->max_discount_amount,
            'min_cart_amount'     => $this->min_cart_amount,
            'applied_on'          => $this->applied_on,
            'product_info'        => $this->product_info,
        ];
    }
}
