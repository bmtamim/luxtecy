<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product_ids = range(1, 15);

        return [
            'product_id' => $this->faker->randomElement($product_ids),
            'title'      => $this->faker->words(2, true),
            'title_cn'   => '產品名稱',
            'price'      => $this->faker->randomFloat(2, 5, 200),
            'quantity'   => rand(1, 5),
            'thumbnail'  => $this->faker->imageUrl(500, 600),
        ];
    }
}
