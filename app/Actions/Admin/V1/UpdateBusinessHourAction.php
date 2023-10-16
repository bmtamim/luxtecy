<?php

namespace App\Actions\Admin\V1;

use App\DTO\Admin\V1\BusinessHourDTO;
use App\Enums\SettingKey;
use App\Http\Requests\BusinessHourRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class UpdateBusinessHourAction
{
    public function __invoke(BusinessHourRequest $request): JsonResponse
    {
        $data = BusinessHourDTO::create($request);
        try {

            Setting::query()->upsert([
                'key'   => SettingKey::BUSINESS_HOURS->value,
                'value' => json_encode($data->business_hours)
            ], 'key');

            Cache::forget(SettingKey::BUSINESS_HOURS->value);

            return jsonResponseFormat(true, null, __('Setting saved!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
