<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Services\Api\V1\OrderService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sub_total',
        'total',
        'status',
        'transaction_id',
        'payment_method',
        'payment_status',
        'shipping_method',
        'shipping_fee',
        'delivery_time',
        'delivery_time_slot',
        'delivery_address',
        'delivery_address_details',
        'delivery_name',
        'delivery_email',
        'delivery_phone',
        'delivery_latitude',
        'delivery_longitude',
        'delivery_postal_code',
    ];

    protected $casts = [
        'status'         => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'delivery_time'  => 'datetime'
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(OrderPromotion::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->order_id = OrderService::generateOrderId();
        });
    }


}
