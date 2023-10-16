<?php

namespace App\Services\Api\V1;

use App\Enums\SettingKey;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class BusinessHourService
{
    public static function getSlots()
    {
        $setting = Cache::rememberForever(SettingKey::BUSINESS_HOURS->value, function () {
            return Setting::query()->where('key', SettingKey::BUSINESS_HOURS->value)->pluck('value')->first();
        });

        if ( ! $setting) {
            return [];
        }

        return json_decode($setting, true);
    }
}
