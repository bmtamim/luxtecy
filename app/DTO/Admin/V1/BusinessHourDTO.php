<?php

namespace App\DTO\Admin\V1;

use App\Abstracts\DataTransferObject;
use App\Enums\BusinessHour;
use App\Enums\SettingKey;
use App\Http\Requests\BusinessHourRequest;

class BusinessHourDTO extends DataTransferObject
{
    public array $business_hours;

    public static function create(BusinessHourRequest $request): BusinessHourDTO
    {
        $data           = $request->all();
        $days           = BusinessHour::getDays();
        $business_hours = [];
        foreach ($days as $day) {
            $time                 = $data[$day] ?? [];
            $business_hours[$day] = cleanUpArray($time);
        }

        return new self([
            'business_hours' => $business_hours
        ]);
    }

    public function toArray(): array
    {
        return [
            SettingKey::BUSINESS_HOURS->value => json_encode($this->business_hours)
        ];
    }
}
