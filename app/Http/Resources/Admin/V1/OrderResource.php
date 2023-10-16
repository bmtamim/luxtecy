<?php

namespace App\Http\Resources\Admin\V1;

use App\Enums\OrderStatus;
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
            'id'                       => $this->id,
            'invoice_id'               => $this->order_id,
            'sub_total'                => $this->sub_total,
            'total'                    => $this->total,
            'status'                   => $this->status->getStatusLabel(),
            'transaction_id'           => $this->transaction_id,
            'payment_method'           => $this->payment_method,
            'payment_status'           => $this->payment_status,
            'shipping_method'          => $this->shipping_method,
            'shipping_fee'             => $this->shipping_fee,
            'delivery_time'            => $this->delivery_time,
            'delivery_address'         => $this->delivery_address,
            'delivery_address_details' => $this->delivery_address_details,
            'delivery_name'            => $this->delivery_name,
            'delivery_email'           => $this->delivery_email,
            'delivery_phone'           => $this->delivery_phone,
            'created_at'               => $this->created_at?->format(config('app.date_format')),
            'is_editable'              => ! in_array($this->status->value, OrderStatus::nonEditableStatuses()),
            'order_items'              => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'order_promotion'          => null,
        ];
    }
}
