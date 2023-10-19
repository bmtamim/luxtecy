<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\BusinessHourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\OpeningHours\OpeningHours;

class AppController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $business_hours = BusinessHourService::getSlots();
        $appInfo        = [
            'name'     => config('app.name'),
            'url'      => config('app.url'),
            'is_open'  => OpeningHours::create($business_hours)->isOpen(),
            'timezone' => config('app.timezone'),
            'currency' => config('app.currency'),
        ];

        return jsonResponseFormat(true, $appInfo);
    }
}
