<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // توليد أسماء واقعية قابلة للتوسع بدون مشكلة unique overflow.
        $categories = [
            'Men Clothing', 'Women Fashion', 'Kids & Baby',
            'Footwear', 'Accessories', 'Sportswear',
            'Watches', 'Handbags', 'Winter Collection', 'Summer Sale'
        ];

        $name = $this->faker->randomElement($categories) . ' ' . strtoupper($this->faker->bothify('??##'));

        return [
            'name'      => $name,
            'parent_id' => null,
        ];
    }
}
// Category::inRandomOrder()->value("id")?? Category::factory()