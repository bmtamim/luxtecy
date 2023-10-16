<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'details'             => $this->details,
            'amount'              => $this->amount,
            'max_discount_amount' => $this->max_discount_amount,
            'min_cart_amount'     => $this->min_cart_amount,
            'applied_on'          => $this->applied_on,
            'product_info'        => $this->product_info ? [
                'title'     => $this->product_info['title'] ?? null,
                'thumbnail' => asset_url($this->product_info['thumbnail'] ?? null),
                'price'     => $this->product_info['price'] ?? 0
            ] : null,
            'is_active'           => (bool) $this->is_active,
            'created_at'          => $this->created_at,
        ];
    }
}
