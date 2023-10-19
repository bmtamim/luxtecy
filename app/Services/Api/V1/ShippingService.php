<?php

namespace App\Services\Api\V1;

use App\Enums\ShippingRule;
use App\Enums\ShippingUnitType;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShippingService
{
    public static function getShippingMethods()
    {
        return Cache::rememberForever('shipping-methods', function () {
            return ShippingMethod::query()
                                 ->where('status', true)
                                 ->orderBy('position', 'asc')
                                 ->get();
        });
    }

    public static function getShippingCharges(Request $request, CartService $cart): array
    {
        $latitude  = cleanUp($request->input('latitude'));
        $longitude = cleanUp($request->input('longitude'));

        $charges = [];
        foreach (self::getShippingMethods() as $method) {
            $charges[$method->name] = self::calculateFee($cart, $method->name, $latitude, $longitude);
        }

        return $charges;
    }

    public static function calculateFee(CartService $cart, $shipping_method, $latitude, $longitude): array
    {
        $shippingMethod = ShippingService::getShippingMethods()->where('name', $shipping_method)->first();
        //Default Values
        $distance = 0;
        $unit     = 1;
        $fee      = $shippingMethod->fee;

        //Unit is 1 in default and when the unit_type is fixed
        if ($shippingMethod->unit_type === ShippingUnitType::QTY->value) {
            $unit = 0 >= $shippingMethod->unit ? $cart->totalQty() : $cart->totalQty() / $shippingMethod->unit;
        } elseif ($shippingMethod->unit_type === ShippingUnitType::KM->value) {
            $distance = self::distanceByKM('23.8074786', '90.3601779');
            $unit     = $distance ?: 0;
        }

        //Check Rule
        if (is_array($shippingMethod->rules) && count($shippingMethod->rules) > 0) {
            foreach ($shippingMethod->rules as $rule) {
                if ( ! is_array($rule) || ! isset($rule['condition']) || ! isset($rule['amount']) || ! isset($rule['fee'])) {
                    continue;
                }
                if ($rule['condition'] === ShippingRule::MINIMUM_AMOUNT->value && $rule['amount'] <= $cart->subTotal()) {
                    $fee = $rule['fee'];
                }
            }
        }

        return [
            'name'         => $shippingMethod->name,
            'distance'     => $distance,
            'delivery_fee' => round($unit * $fee, 2)
        ];
    }

    public static function distanceByKM($lat, $lon): float|int|null
    {
        //43200 = 12h
        return Cache::remember($lat.','.$lon, 43200, function () use ($lat, $lon) {
            $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'destinations' => $lat.','.$lon,
                'origins'      => config('core.shop_latitude').','.config('core.shop_longitude'),
                'key'          => config('core.google_map_api_key')
            ]);

            if ($response->successful()
                && ! isset($response['rows'])
                && ! isset($response['rows'][0])
                && ! isset($response['rows'][0]['elements'])
                && ! isset($response['rows'][0]['elements'][0])
                && ! isset($response['rows'][0]['elements'][0]['distance'])
                && ! isset($response['rows'][0]['elements'][0]['distance']['value'])
            ) {
                return null;
            }
            $distance_miter = $response['rows'][0]['elements'][0]['distance']['value'];
            $distance_km    = $distance_miter / 1000;

            return max($distance_km, 1);
        });
    }
}
