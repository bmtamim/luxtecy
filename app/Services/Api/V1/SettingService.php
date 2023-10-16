<?php

namespace App\Services\Api\V1;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public static function getAll()
    {
        return Cache::rememberForever('settings', function () {
            return Setting::query()->select([
                'id', 'key', 'value'
            ])->get()->mapWithKeys(function ($item, $key) {
                return [$item['key'] => $item['value']];
            });
        });
    }

    public static function get(string|int $key)
    {
        return isset(self::getAll()[$key]) ? self::getAll()[$key] : null;
    }

    public static function prepareSettings(array $settings, int $workspace_id): array
    {

        $data = [];
        foreach ($settings as $key => $value) {
            $data[] = [
                'key'   => $key,
                'value' => is_array($value) ? json_encode($value) : $value,
            ];
        }

        return $data;
    }
}
