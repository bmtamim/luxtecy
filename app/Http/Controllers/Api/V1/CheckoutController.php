<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\CheckoutCalculateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CheckoutCalculateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function calculate(CheckoutCalculateRequest $request, CheckoutCalculateAction $action): JsonResponse
    {
        return $action($request);
    }
}
