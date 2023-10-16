<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'invoice_id'               => $this->order_id,
            'total'                    => $this->total,
            'status'                   => $this->status->getStatusLabel(),
            'delivery_address'         => $this->delivery_address,
            'delivery_address_details' => $this->delivery_address_details,
            'delivery_name'            => $this->delivery_name,
            'delivery_email'           => $this->delivery_email,
            'delivery_phone'           => $this->delivery_phone,
            'created_at'               => $this->created_at?->format(config('app.date_format')),
        ];
    }
}
