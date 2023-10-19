<?php

namespace App\DTO\Api\V1;

use App\Abstracts\DataTransferObject;

class CartStoreDTO extends DataTransferObject
{
    public int $cart_id;
    public int $product_id;
    public float $quantity;
    public array $product_info;


    public static function create($cart_id, $product, $quantity): CartStoreDTO
    {
        return new self([
            'cart_id'      => $cart_id,
            'product_id'   => $product->id,
            'quantity'     => $quantity,
            'product_info' => [
                'title'     => $product->title,
                'title_cn'  => $product->title_cn,
                'thumbnail' => $product->thumbnail,
            ]
        ]);
    }

    public function toArray(): array
    {
        return [
            'cart_id'      => $this->cart_id,
            'product_id'   => $this->product_id,
            'quantity'     => $this->quantity,
            'product_info' => $this->product_info,
        ];
    }

    public function update(): array
    {
        return [
            'quantity'     => $this->quantity,
            'product_info' => $this->product_info,
        ];
    }
}
