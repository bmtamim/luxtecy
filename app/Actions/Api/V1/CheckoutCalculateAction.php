<?php

namespace App\Actions\Api\V1;

use App\Enums\PromotionEnum;
use App\Http\Requests\Api\V1\CheckoutCalculateRequest;
use App\Services\Api\V1\CartService;
use App\Services\Api\V1\CheckoutCalculateService;
use App\Services\Api\V1\ShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutCalculateAction
{
    public function __invoke(CheckoutCalculateRequest $request): JsonResponse
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

            return jsonResponseFormat(true, $calculate->prepareData());
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }


}
