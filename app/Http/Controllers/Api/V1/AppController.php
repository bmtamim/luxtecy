<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\BusinessHourService;
use App\Services\Api\V1\TimeRangeService;
use Carbon\CarbonImmutable;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Carbon;
use Spatie\OpeningHours\OpeningHours;
use Spatie\OpeningHours\OpeningHoursForDay;

class AppController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(): JsonResponse
    {
        $date           = 'today, 02:00pm - 03:00pm';
        $dateSplit      = explode('-', $date);
        $business_hours = BusinessHourService::getSlots();
        $range          = OpeningHours::create($business_hours)->forDay('monday');

        $appInfo = [
            'name'       => config('app.name'),
            'url'        => config('app.url'),
            'is_open'    => OpeningHours::create($business_hours)->isOpen(),
            'time_slots' => TimeRangeService::generateDeliveryRange(),
            'timezone'   => config('app.timezone'),
            'currency'   => config('app.currency'),
            'test'       => Carbon::parse(ltrim($dateSplit[1]))->format('d m Y h:i:a')
        ];

        return jsonResponseFormat(true, $appInfo);
    }
}
