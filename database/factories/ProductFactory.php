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
    public function definition()
{
    // مصفوفة مقسمة حسب الفئات التي طلبتها
    $products = [
        'Clothing' => [
            'Classic Slim Fit Shirt', 'Oversized Cotton Hoodie', 'Denim Jacket Blue', 
            'Summer Floral Dress', 'Chino Pants Beige', 'Casual Polo Shirt'
        ],
        'Accessories' => [
            'Polarized Sunglasses', 'Leather Crossbody Bag', 'Stainless Steel Watch', 
            'Woolen Winter Scarf', 'Minimalist Gold Bracelet', 'Sporty Backpack'
        ],
        'Shoes' => [
            'Running Sports Sneakers', 'Classic Leather Loafers', 'High-Heel Sandals', 
            'Canvas Low Top Shoes', 'Outdoor Hiking Boots', 'Formal Oxford Shoes'
        ]
    ];

    // اختيار فئة عشوائية ثم اختيار منتج عشوائي منها
    $categoryName = $this->faker->randomElement(array_keys($products));
    $productName = $this->faker->randomElement($products[$categoryName]);

    return [
        'name'        => $productName,
        'price'       => $this->faker->randomFloat(2, 20, 500),
        'description' => $this->faker->sentence(10),
        'vendor_id'   => \App\Models\Vendor::inRandomOrder()->first()->id ?? 1,
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? 1,
        'views'       => $this->faker->numberBetween(0, 1000),
        'is_active' => true,
    ];
}
}
