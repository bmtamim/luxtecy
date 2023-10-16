<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'delivery_address',
        'delivery_address_details',
        'delivery_name',
        'delivery_email',
        'delivery_phone',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix          = '0'.date('y').'-';
            $uniqStr         = $prefix.rand(1111, 9999);
            $dbID            = Order::query()->max('id') + 1;
            $uniqStr         .= $dbID;
            $model->order_id = $uniqStr;
        });
    }


}
