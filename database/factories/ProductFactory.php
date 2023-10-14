<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $labels = ['New Item', 'Most Popular', 'Most Ordered'];

        return [
            'title'         => $this->faker->words(2, true),
            'title_cn'      => '產品名稱',
            'regular_price' => $this->faker->randomFloat(2, 5, 200),
            'stock'         => $this->faker->randomFloat(0, 0, 30),
            'description'   => $this->faker->sentences(2, true),
            'label'         => $this->faker->randomElement($labels),
            'thumbnail'     => $this->faker->imageUrl(500, 600),
        ];
    }
}
