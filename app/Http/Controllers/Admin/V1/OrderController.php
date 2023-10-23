<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\UpdateOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\OrderRequest;
use App\Http\Resources\Admin\V1\OrderIndexResource;
use App\Http\Resources\Admin\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $orders = Order::query()
                       ->select([
                           'id', 'order_id', 'total', 'status', 'delivery_address', 'delivery_address_details',
                           'delivery_name', 'delivery_email', 'delivery_phone', 'created_at'
                       ])
                       ->latest()->paginate(10);

        return jsonResponseFormat(true, OrderIndexResource::collection($orders)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::query()
                      ->with(['orderItems', 'promotion'])
                      ->findOrFail($id);

        return jsonResponseFormat(true, new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order, UpdateOrderAction $action)
    {
        return $action($request, $order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
