<?php

namespace Database\Seeders;

use App\Enums\ShippingRule;
use App\Enums\ShippingUnitType;
use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingMethod::query()->updateOrCreate([
            'name' => 'instant',
        ], [
            'display_name'  => 'Instant',
            'description'   => '< 60 min',
            'delivery_info' => 'by Grab / Lalamove',
            'unit_type'     => ShippingUnitType::KM->value,
            'unit'          => 1,
            'fee'           => 1,
            'rules'         => null,
            'status'        => true,
            'position'      => 1,
        ]);

        ShippingMethod::query()->updateOrCreate([
            'name' => 'courier',
        ], [
            'display_name'  => 'Courier',
            'description'   => 'arriving next day',
            'delivery_info' => 'order after 3pm count for the next day.',
            'unit_type'     => ShippingUnitType::FIXED->value,
            'unit'          => 0,
            'fee'           => 12,
            'rules'         => [
                [
                    'amount'    => 100,
                    'condition' => ShippingRule::MINIMUM_AMOUNT->value,
                    'fee'       => 5
                ]
            ],
            'status'        => true,
            'position'      => 2,
        ]);
    }
}
