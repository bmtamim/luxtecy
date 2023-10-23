<?php

namespace App\Actions\Admin\V1;

use App\Enums\SettingKey;
use App\Http\Requests\Admin\V1\PostalCodeRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class UpdatePostalCodeAction
{
    public function __invoke(PostalCodeRequest $request): JsonResponse
    {
        try {
            $data = cleanUpArray($request->input('exclude'));

            Setting::query()->upsert([
                'key'   => SettingKey::POSTAL_CODES->value,
                'value' => json_encode([
                    'exclude' => $data
                ])
            ], 'key');

            Cache::forget(SettingKey::POSTAL_CODES->value);

            return jsonResponseFormat(true, null, __('Setting saved!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
