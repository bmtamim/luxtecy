<?php

namespace App\Actions\Api\V1;

use App\DTO\Api\V1\CartStoreDTO;
use App\Http\Requests\Admin\V1\CartUpdateRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class UpdateCartAction
{
    public function __invoke(CartUpdateRequest $request)
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

            if (0 >= $quantity) {
                CartItem::query()
                        ->where(['cart_id' => $cart->id, 'product_id' => $product->id])
                        ->delete();

                return jsonResponseFormat(true, null, __('Product removed from cart!'));
            }

            //Cart Item
            $cartItem = CartItem::query()
                                ->where(['cart_id' => $cart->id, 'product_id' => $product->id])
                                ->first();

            $cartItemDTO = CartStoreDTO::create($cart->id, $product, $quantity);

            $cartItem?->update($cartItemDTO->update());

            return jsonResponseFormat(true, null, __('Cart updated!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
