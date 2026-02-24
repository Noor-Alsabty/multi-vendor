<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'code' => strtoupper($this->faker->unique()->bothify('PROMO-###??')),
        'discount_type' => $this->faker->randomElement(['fixed', 'percentage']),
        'discount_value' => $this->faker->randomFloat(2, 5, 100),
        'start_date' => now(),
        'end_date' => now()->addDays(30),
        'usage_limit' => $this->faker->numberBetween(50, 500),
        'used_count' => 0,
        'applies_to' => $this->faker->randomElement(['all', 'specific_category', 'first_order']),
    ];
}
}
