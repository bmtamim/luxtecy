<?php

namespace App\Services\Api\V1;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderService
{

    public static function generateOrderId(): string
    {
        $suffix   = '-'.date('dmy');
        $order_id = rand(1111, 9999).$suffix;
        $exist    = Order::query()->where(['order_id' => $order_id])->first();
        if ($exist) {
            $order_id = self::generateOrderId();
        }

        return $order_id;
    }
}
