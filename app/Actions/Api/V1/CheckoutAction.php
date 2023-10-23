<?php

namespace App\Actions\Api\V1;

use App\DTO\Api\V1\OrderDTO;
use App\DTO\Api\V1\OrderItemDTO;
use App\DTO\Api\V1\OrderPromotionDTO;
use App\Http\Requests\Admin\V1\CheckoutRequest;
use App\Models\Order;
use App\Services\Api\V1\CartService;
use App\Services\Api\V1\CheckoutCalculateService;
use App\Services\Api\V1\ShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutAction
{
    public function __invoke(CheckoutRequest $request): JsonResponse
    {
        $user_token = cleanUp($request->input('user_token'));
        try {
            //Init Cart
            $cart = new CartService($user_token);

            //Check cart
            if ( ! $cart->cart || 0 >= count($cart->cartItems)) {
                return jsonResponseFormat(false, null, __('Cart is empty!'), 500);
            }

            //Get Shipping Charges
            $shippingMethods = ShippingService::getShippingCharges($request, $cart);

            //Calculate Cart
            $calculate = new CheckoutCalculateService($request, $cart, $shippingMethods);

            //DB Transaction Start for Order
            DB::beginTransaction();
            //Create Order
            $orderDTO = OrderDTO::create($request, $calculate);

            $order = Order::query()->create($orderDTO->toArray());

            //Insert Order Item
            $cartItems = $calculate->cart->cartItems->map(function ($item) use ($order) {
                return OrderItemDTO::create($item, $order->id)->toArray();
            });
            $order->orderItems()->createMany($cartItems);

            //Order promotion
            if ($calculate->cart->promotion) {
                $orderPromotion = OrderPromotionDTO::create($calculate, $order->id);
                $order->promotion()->create($orderPromotion->toArray());
            }
            //Delete Cart
            $cart->cart->cartItems()->delete();
            DB::commit();
            //DB Transaction End for Order

            //Handle Payment
            $trx_id = Str::random();
            $order->update($orderDTO->payment($trx_id, true));


            return jsonResponseFormat(true, $order, __('Order created.'));

        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
