<?php

namespace App\Actions\Admin\V1;

use App\DTO\Admin\V1\OrderDTO;
use App\Enums\OrderStatus;
use App\Http\Requests\Admin\V1\OrderRequest;
use App\Http\Resources\Admin\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class UpdateOrderAction
{
    public function __invoke(OrderRequest $request, Order $order): JsonResponse
    {

        if (in_array($order->status->value, OrderStatus::nonEditableStatuses())) {
            return jsonResponseFormat(false, null, __('Order is not editable.'), 500);
        }

        $data = OrderDTO::create($request);
        try {

            $order->update($data->toArray());

            return jsonResponseFormat(true, new OrderResource($order), __('Order Updated!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
