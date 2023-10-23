<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'title',
        'title_cn',
        'price',
        'quantity',
        'thumbnail',
    ];

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['price'] * $attributes['quantity']
        );
    }
}
