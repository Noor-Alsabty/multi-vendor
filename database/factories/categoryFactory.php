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
        // قائمة أصناف واقعية لتجنب الأسماء اللاتينية
        $categories = [
            'Men Clothing', 'Women Fashion', 'Kids & Baby', 
            'Footwear', 'Accessories', 'Sportswear', 
            'Watches', 'Handbags', 'Winter Collection', 'Summer Sale'
        ];

        $name = $this->faker->unique()->randomElement($categories);

        return [
            'name'      => $name,
            'parent_id' => null, // نتركها نول حالياً ليتم التحكم بها من السيرفر
        ];
    }
}
// Category::inRandomOrder()->value("id")?? Category::factory()