<?php

namespace App\Actions\Api\V1;

use App\DTO\Api\V1\CartStoreDTO;
use App\Http\Requests\Api\V1\CartStoreRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CartStoreAction
{
    public function __invoke(CartStoreRequest $request): JsonResponse
    {
        $userToken = (string) cleanUp($request->input('user_token'));
        $productId = (int) cleanUp($request->input('product_id'));
        $quantity  = (float) cleanUp($request->input('quantity'));
        try {
            //Validate Product
            $product = Product::query()->find($productId);
            if ( ! $product) {
                return jsonResponseFormat(false, null, __('Invalid product.'), 422);
            }

            if ($product->stock < $quantity) {
                return jsonResponseFormat(false, null, __('Insufficient stock.'), 422);
            }

            //Cart
            $cart = Cart::query()
                        ->where('user_token', $userToken)->first();

            if ( ! $cart) {
                $cart = Cart::query()->create([
                    'user_token' => $userToken
                ]);
            }

            //Cart Item
            $cartItem = CartItem::query()
                                ->where(['cart_id' => $cart->id, 'product_id' => $product->id])
                                ->first();

            $total_quantity = ($cartItem?->quantity ?? 0) + $quantity;

            if ($product->stock < $total_quantity) {
                return jsonResponseFormat(false, null,
                    'We have '.$product->stock.' items in our stock. Your cart already have '.($cartItem?->quantity ?? 0),
                    422);
            }

            $cartItemDTO = CartStoreDTO::create($cart->id, $product, $total_quantity);

            if ($cartItem) {
                $cartItem->update($cartItemDTO->update());
            } else {
                CartItem::create($cartItemDTO->toArray());
            }

            return jsonResponseFormat(true, null, __('Product added to the cart!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
