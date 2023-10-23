<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product_info = is_array($this->product_info) ? $this->product_info : [];

        return [
            'name'           => $this->name,
            'type'           => $this->type,
            'amount'         => amount_format($this->amount),
            'applied_amount' => amount_format($this->applied_amount),
            'applied_on'     => null,
            'product_info'   => [
                'title'     => $product_info['title'] ?? '',
                'thumbnail' => isset($product_info['thumbnail']) ? asset_url($product_info['thumbnail']) : '',
                'price'     => isset($product_info['price']) ? amount_format($product_info['price'], null, false) : ''
            ]
        ];
    }
}
