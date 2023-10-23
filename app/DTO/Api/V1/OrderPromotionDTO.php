<?php

namespace App\DTO\Api\V1;

use App\Abstracts\DataTransferObject;
use App\Models\Promotion;
use App\Services\Api\V1\CheckoutCalculateService;

class OrderPromotionDTO extends DataTransferObject
{
    public int $order_id;
    public int $promotion_id;
    public string $name;
    public string $type;
    public float $amount;
    public float $applied_amount;
    public ?string $applied_on;
    public ?array $product_info;

    public static function create(CheckoutCalculateService $data, $order_id): OrderPromotionDTO
    {
        return new self([
            'order_id'       => $order_id,
            'promotion_id'   => $data->cart->promotion?->id,
            'name'           => $data->cart->promotion?->name,
            'type'           => $data->cart->promotion?->type,
            'amount'         => $data->cart->promotion?->amount,
            'applied_on'     => $data->cart->promotion?->applied_on,
            'applied_amount' => $data->getPromotionAmount(),
            'product_info'   => $data->cart->promotion?->product_info,
        ]);
    }

    public function toArray(): array
    {
        return [
            'promotion_id'   => $this->promotion_id,
            'name'           => $this->name,
            'type'           => $this->type,
            'amount'         => $this->amount,
            'applied_on'     => $this->applied_on,
            'applied_amount' => $this->applied_amount,
            'product_info'   => $this->product_info,
        ];
    }
}
