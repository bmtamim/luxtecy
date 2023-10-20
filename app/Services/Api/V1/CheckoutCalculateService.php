<?php

namespace App\Services\Api\V1;


use App\Enums\PromotionEnum;
use Illuminate\Http\Request;

class CheckoutCalculateService
{
    public CartService $cart;
    public ?array $shippingMethods;
    public Request $request;


    public function __construct(Request $request, CartService $cart, array $shippingCharges)
    {
        $this->cart            = $cart;
        $this->request         = $request;
        $this->shippingMethods = $shippingCharges;

    }

    public function prepareData(): array
    {
        return [
            'items'             => $this->cart->cartItems,
            'payment'           => $this->preparePaymentData(),
            'shipping_methods'  => $this->prepareShippingMthods(),
            'promotion'         => $this->cart->promotion,
            'awaited_promotion' => $this->cart->awaited_promotion,
        ];
    }

    private function prepareShippingMthods(): array
    {
        return array_map(function ($item) {
            $newData                 = [];
            $newData['name']         = $item['name'];
            $newData['distance']     = $item['distance'] > 0 ? $item['distance'].' kM' : null;
            $newData['delivery_fee'] = amount_format($item['delivery_fee']);

            return $newData;
        }, $this->shippingMethods);
    }

    private function preparePaymentData(): array
    {

        $data = [
            'subtotal' => amount_format($this->cart->cartTotal()),
        ];

        if ($this->deliveryFee()) {
            $data['delivery_fee'] = amount_format($this->deliveryFee());
        }
        $data['offer_amount'] = amount_format($this->getPromotionAmount());

        $data['total'] = amount_format($this->total());

        return $data;
    }

    public function getPromotionAmount()
    {
        $promotionAmount = 0;
        $applied_on      = $this->deliveryFee() ?? 0;


        //
        if ($this->cart->promotion?->applied_on === PromotionEnum::CART->value) {
            $applied_on = $this->cart->cartTotal();
        }

        //
        if ($this->cart->promotion?->type === PromotionEnum::FIXED->value) {
            $promotionAmount = $this->cart->promotion?->amount ?? 0;
        } elseif ($this->cart->promotion?->type === PromotionEnum::PERCENTAGE->value) {
            $promotionAmount = ($applied_on / 100) * $this->cart->promotion?->amount;
        }

        //
        if ($this->cart->promotion?->applied_on === PromotionEnum::DELIVERY_FEE->value) {
            $promotionAmount = min($promotionAmount, $this->deliveryFee());
        }

        return $promotionAmount;
    }

    public function total()
    {
        $total = $this->cart->cartTotal();
        if ($this->deliveryFee()) {
            $total += $this->deliveryFee();
        }
        if ($this->getPromotionAmount()) {
            $total -= $this->getPromotionAmount();
        }

        return $total;
    }

    private function deliveryFee()
    {
        $shipping_method = cleanUp($this->request->input('shipping_method'));
        if (
            ! $shipping_method
            || ! is_array($this->shippingMethods)
            || ! isset($this->shippingMethods[$shipping_method])
            || ! isset($this->shippingMethods[$shipping_method]['delivery_fee'])
        ) {
            return null;
        }

        return $this->shippingMethods[$shipping_method]['delivery_fee'];
    }
}
