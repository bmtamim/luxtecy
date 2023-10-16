<?php

namespace App\Http\Resources\Admin\V1;

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
            'title'       => $this->title,
            'title_cn'    => $this->title_cn,
            'price'       => $this->price,
            'quantity'    => $this->quantity,
            'total_price' => $this->price * $this->quantity,
            'thumbnail'   => asset_url($this->thumbnail),
        ];
    }
}
