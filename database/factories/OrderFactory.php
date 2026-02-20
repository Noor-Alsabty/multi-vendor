<?php

namespace Database\Factories;

use App\Models\User;
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
    return [
        'customer_id' =>User::factory(), // ينشئ يوزر جديد
        'coupon_id' => null, // يفضل ربطه في السيدر بكوبون موجود
        'total_amount' => $this->faker->randomFloat(2, 100, 2000),
        'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered']),
        'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        'shipped_at' => null,
    ];
}
}
