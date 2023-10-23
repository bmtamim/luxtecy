<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\CheckoutAction;
use App\Actions\Api\V1\CheckoutCalculateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\CheckoutRequest;
use App\Http\Requests\Api\V1\CheckoutCalculateRequest;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request, CheckoutAction $action): JsonResponse
    {
        return $action($request);
    }

    public function calculate(CheckoutCalculateRequest $request, CheckoutCalculateAction $action): JsonResponse
    {
        return $action($request);
    }
}
