<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ربط البائع بمستخدم موجود أو إنشاء مستخدم جديد له
            'user_id' => User::factory(), 
            
            // استخدام أسماء متاجر واقعية بدلاً من اللاتينية
            'store_name' => $this->faker->unique()->randomElement([
                'ZARA Official', 'Nike Jordan', 'Adidas Global', 
                'H&M Fashion', 'Gucci Luxury', 'Rolex Boutique', 
                'Puma Sports', 'Levi\'s Store', 'Apple Authorized', 'Samsung Galaxy'
            ]),
            
            'store_email' => $this->faker->unique()->safeEmail(),
            'store_phone' => $this->faker->phoneNumber(),
            'store_logo'  => null, // أو يمكنك وضع رابط صورة وهمية: $this->faker->imageUrl(200, 200, 'business')
            'description' => $this->faker->paragraph(),
            
            // الحالة
            'verification_status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'verification_reject_reason' => null,
            'verification_date' => now(),
        ];
    }
}
