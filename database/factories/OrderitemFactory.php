<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderitemFactory extends Factory
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
        'variant_id' =>ProductVariant::factory(), // يفترض وجود موديل بهذا الاسم
        'quantity' => $this->faker->numberBetween(1, 5),
        'price' => $this->faker->randomFloat(2, 20, 500),
    ];
}
}
