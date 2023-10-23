<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            self::optimizeClear($model);
        });
        self::updated(function ($model) {
            self::optimizeClear($model);
        });
        self::deleted(function ($model) {
            self::optimizeClear($model);
        });
    }

    private static function optimizeClear($model): void
    {
        Cache::forget('settings');
    }
}
