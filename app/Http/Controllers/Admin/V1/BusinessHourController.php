<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\UpdateBusinessHourAction;
use App\Enums\SettingKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessHourRequest;
use App\Models\Setting;
use App\Services\Api\V1\BusinessHourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class BusinessHourController extends Controller
{
    public function index(): JsonResponse
    {

        return jsonResponseFormat(true, BusinessHourService::getSlots());
    }

    public function store(BusinessHourRequest $request, UpdateBusinessHourAction $action): JsonResponse
    {
        return $action($request);
    }
}
