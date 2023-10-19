<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'details',
        'amount',
        'max_discount_amount',
        'min_cart_amount',
        'applied_on',
        'product_info',
        'is_active',
    ];

    protected $casts = [
        'product_info' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function () {
            self::clearCache();
        });
        self::updated(function () {
            self::clearCache();
        });
        self::deleted(function () {
            self::clearCache();
        });

    }

    public static function clearCache()
    {
        Cache::forget('promotions');
    }
}
