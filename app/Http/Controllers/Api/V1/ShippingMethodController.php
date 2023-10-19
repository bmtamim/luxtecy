<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\ShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'user_token' => ['required', 'string', 'exists:user_sessions,token']
        ]);

        $methods = ShippingService::getShippingMethods();

        return jsonResponseFormat(true, $methods);

    }
}
