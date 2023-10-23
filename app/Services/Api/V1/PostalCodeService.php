<?php

namespace App\Services\Api\V1;

use App\Enums\SettingKey;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class PostalCodeService
{
    public static function postalCodes()
    {
        $setting = Cache::rememberForever(SettingKey::POSTAL_CODES->value, function () {
            return Setting::query()->where('key', SettingKey::POSTAL_CODES->value)->pluck('value')->first();
        });

        if ( ! $setting) {
            return [];
        }

        return json_decode($setting, true);
    }

    public static function excluded(): array
    {
        return isset(self::postalCodes()['exclude']) ? self::postalCodes()['exclude'] : [];
    }
}
