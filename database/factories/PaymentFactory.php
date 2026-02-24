<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // يربطها بطلب تلقائياً
            'card_number_masked' => '**** **** **** ' . $this->faker->numerify('####'), // يولد رقم وهمي منتهي بـ 4 أرقام
            'card_holder_name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'status' => $this->faker->randomElement(['completed', 'failed', 'pending']),
            'payment_date' => now(),
        ];
    }
}