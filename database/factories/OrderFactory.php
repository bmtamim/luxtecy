<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shipping = ['Instant', 'Currier'];

        return [
            'sub_total'                => $this->faker->randomFloat(2, 50, 10000),
            'total'                    => $this->faker->randomFloat(2, 50, 10000),
            'status'                   => OrderStatus::PENDING_PAYMENT->value,
            'shipping_method'          => $this->faker->randomElement($shipping),
            'shipping_fee'             => 0,
            'delivery_address'         => $this->faker->address,
            'delivery_address_details' => 'Floor 3, Apartment 2, Road5, Block H',
            'delivery_name'            => $this->faker->name,
            'delivery_email'           => $this->faker->safeEmail,
            'delivery_phone'           => $this->faker->phoneNumber,
        ];
    }
}
