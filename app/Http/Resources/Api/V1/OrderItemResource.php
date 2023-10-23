<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'title'                 => $this->title,
            'title_cn'              => $this->title_cn,
            'price'                 => amount_format($this->price, null, false),
            'price_formatted'       => amount_format($this->price),
            'quantity'              => $this->quantity,
            'total_price'           => amount_format($this->total_price, null, false),
            'total_price_formatted' => amount_format($this->total_price),
            'thumbnail'             => asset_url($this->thumbnail),
        ];
    }
}
