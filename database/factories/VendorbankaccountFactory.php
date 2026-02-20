<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorBankAccount>
 */
class VendorbankaccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // أسماء بنوك عالمية مشهورة
            'bank_name' => $this->faker->randomElement([
                'HSBC Bank', 'JPMorgan Chase', 'Bank of America', 
                'Standard Chartered', 'Barclays', 'Citibank'
            ]),
            
            // توليد رقم IBAN وهمي يبدأ بـ رمز الدولة (مثلاً SA للسعودية أو AE للإمارات)
            'iban' => $this->faker->iban('SA'), 
            
            // اسم صاحب الحساب (غالباً يكون اسم الشخص أو اسم الشركة)
            'account_holder_name' => $this->faker->name(),
            
            'account_number' => $this->faker->bankAccountNumber(),
            
            'status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            
            'verified_at' => function (array $attributes) {
                return $attributes['status'] === 'verified' ? now() : null;
            },
        ];
    }
}
