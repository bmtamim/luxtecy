<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __invoke($id): JsonResponse
    {
        $order = Order::query()
                      ->with(['orderItems', 'promotion'])
                      ->findOrFail($id);

        return jsonResponseFormat(true, new OrderResource($order));
    }
}
