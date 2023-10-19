<?php

namespace App\Services\Api\V1;

use App\Models\Promotion;
use Illuminate\Support\Facades\Cache;

class PromotionService
{
    public static function getPromotions()
    {
        return Cache::rememberForever('promotions', function () {
            return Promotion::query()->where('is_active', true)->get();
        });
    }
}
