<?php

namespace App\DTO\Api\V1;

use App\Abstracts\DataTransferObject;
use App\Services\Api\V1\CheckoutCalculateService;

class OrderItemDTO extends DataTransferObject
{
    public int $order_id;
    public int $product_id;
    public string $title;
    public string $title_cn;
    public float $price;
    public float $quantity;
    public string $thumbnail;

    public static function create($cartItem, $order_id): OrderItemDTO
    {
        return new self([
            'order_id'   => $order_id,
            'product_id' => $cartItem->product_id,
            'title'      => $cartItem->product->title,
            'title_cn'   => $cartItem->product->title_cn,
            'price'      => $cartItem->product->regular_price,
            'quantity'   => $cartItem->quantity,
            'thumbnail'  => $cartItem->product->thumbnail,
        ]);
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'title'      => $this->title,
            'title_cn'   => $this->title_cn,
            'price'      => $this->price,
            'quantity'   => $this->quantity,
            'thumbnail'  => $this->thumbnail,
        ];
    }
}
