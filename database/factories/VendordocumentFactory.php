<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorDocument>
 */
class VendordocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // سنترك الـ vendor_id ليتم تحديده من الـ Seeder
            'document_type' => $this->faker->randomElement(['ID Card', 'Commercial Register', 'Tax Certificate', 'Passport']),
            'document_path' => 'documents/samples/' . $this->faker->uuid() . '.pdf',
            'document_number' => $this->faker->bothify('DOC-####-####'),
            'status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'rejection_reason' => function (array $attributes) {
                return $attributes['status'] === 'rejected' ? $this->faker->sentence() : null;
            },
            'uploaded_at' => now(),
            'verified_at' => function (array $attributes) {
                return $attributes['status'] === 'verified' ? now() : null;
            },
        ];
    }
}
