<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'invoice_id'         => $this->order_id,
            'sub_total'          => amount_format($this->sub_total),
            'total'              => amount_format($this->total),
            'status'             => $this->status->getStatusLabel(),
            'transaction_id'     => $this->transaction_id,
            'payment_method'     => $this->payment_method,
            'payment_status'     => $this->payment_status->getStatusLabel(),
            'shipping_method'    => $this->shipping_method,
            'shipping_fee'       => amount_format($this->shipping_fee),
            'delivery_time'      => $this->delivery_time?->format(config('app.date_format')),
            'delivery_time_slot' => $this->delivery_time_slot,
            'delivery_address'   => [
                'name'            => $this->delivery_name,
                'phone'           => $this->delivery_phone,
                'address'         => $this->delivery_address,
                'address_details' => $this->delivery_address_details,
            ],
            'created_at'         => $this->created_at?->format(config('app.date_format')),
            'orderItems'         => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'promotion'          => new OrderPromotionResource($this->whenLoaded('promotion'))
        ];
    }
}
