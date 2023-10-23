<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'promotion_id',
        'name',
        'type',
        'amount',
        'applied_amount',
        'applied_on',
        'product_info',
    ];

    protected $casts = [
        'product_info' => 'array'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
