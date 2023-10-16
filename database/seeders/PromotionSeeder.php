<?php

namespace Database\Seeders;

use App\Enums\PromotionEnum;
use App\Models\Promotion;
use App\Services\FileUploadService;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = new File(public_path('assets/img/300x300.svg'));
        //Create Free Pot Promotion
        Promotion::query()->updateOrCreate([
            'id' => 1,
        ], [
            'name'            => 'Free Pot',
            'type'            => PromotionEnum::PRODUCT->value,
            'details'         => 'Get free pot',
            'amount'          => 0,
            'min_cart_amount' => 50,
            'product_info'    => [
                'title'     => 'Free Pot',
                'thumbnail' => FileUploadService::uploadFile($image),
                'price'     => 0
            ],
            'is_active'       => true,
        ]);

        //Create Free Pot Promotion
        Promotion::query()->updateOrCreate([
            'id' => 2,
        ], [
            'name'            => '10 Delivery Fee',
            'type'            => PromotionEnum::FIXED->value,
            'details'         => 'Get [currency]10 Delivery fees discount.',
            'amount'          => 10,
            'min_cart_amount' => 100,
            'applied_on'      => PromotionEnum::DELIVERY_FEE->value,
            'is_active'       => true,
        ]);
    }
}
