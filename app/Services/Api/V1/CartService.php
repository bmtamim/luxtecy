<?php

namespace App\Services\Api\V1;

use App\Http\Resources\Api\V1\PromotionResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CartService
{
    public ?Cart $cart = null;
    public string $user_token;
    public Collection $cartItems;
    public ?Collection $allPromotions = null;
    public ?Promotion $promotion = null;
    public array $awaited_promotion = [];

    public function __construct($user_token)
    {
        $this->user_token = $user_token;
        $this->initCart();
        $this->getAllPromotions();
        $this->getPromotion();
        $this->getNearestPromotion();
    }

    public function initCart(): void
    {
        $this->cartItems = Collection::make();
        if ( ! $this->cart) {
            $this->cart = Cart::where(['user_token' => $this->user_token])->first();
        }
        if ($this->cart) {
            $this->cartItems = $this->cart->cartItems()->with('product')->get();
        }
    }

    public function subTotal(): float
    {
        $sub_total = $this->cartItems->reduce(function (?float $carry, CartItem $item) {
            return $carry + ($item->quantity * $item->product->regular_price);
        }, 0);

        return round($sub_total, 2);
    }

    public function totalQty(): float
    {
        $quantity = $this->cartItems->reduce(function (?float $carry, CartItem $item) {
            return $carry + $item->quantity;
        });

        return round($quantity, 2);
    }

    public function cartTotal(): float
    {
        return $this->subTotal();
    }

    public function getPromotion(): void
    {
        if ( ! $this->promotion) {
            $this->promotion = $this->allPromotions?->where('min_cart_amount', '<=',
                $this->subTotal())->sortByDesc('min_cart_amount')->first();
        }
    }

    public function getNearestPromotion(): void
    {
        $promotion = $this->allPromotions?->where('min_cart_amount', '>',
            $this->subTotal())->sortBy('min_cart_amount',
            SORT_ASC)->first();
        if ($promotion) {

            $this->awaited_promotion = [
                'remaining_amount' => amount_format($promotion->min_cart_amount - $this->subTotal()),
                'promotion_title'  => $promotion->name,
                'required_amount'  => amount_format($promotion->min_cart_amount),
                'subtotal'         => amount_format($this->subTotal()),
                'percentage'       => ($this->subTotal() / $promotion->min_cart_amount) * 100,
            ];
        }
    }

    public function getAllPromotions(): void
    {
        if ( ! $this->allPromotions) {
            $this->allPromotions = PromotionService::getPromotions();
        }
    }

}
