<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerificationPackages>
 */
class VerificationPackagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'duration_days' => $this->faker->randomElement([30, 90, 180, 365]),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
