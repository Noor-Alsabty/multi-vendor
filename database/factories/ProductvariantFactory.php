<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductvariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'color' => $this->faker->safeColorName(), // Red, Blue, Black...
        'size'  => $this->faker->randomElement(['S', 'M', 'L', 'XL', '38', '39', '40', '41', '42']),
        'stock' => $this->faker->numberBetween(5, 100),
        'SKU'   => strtoupper($this->faker->unique()->bothify('??-####')), 
    ];
}
}
