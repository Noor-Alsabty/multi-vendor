<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shippment>
 */
class ShippmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'order_id' =>Order::factory(),
        'carrier' => $this->faker->randomElement(['Aramex', 'DHL', 'FedEx', 'UPS']),
        'tracking_number' => strtoupper($this->faker->bothify('TRK-##########')),
    ];
}
}
