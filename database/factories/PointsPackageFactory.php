<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PointsPackage>
 */
class PointsPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true) . ' Points',
            'points' => $this->faker->randomElement([50, 100, 250, 500, 1000]),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'bonus_points' => $this->faker->randomElement([0, 10, 50]),
            'is_active' => true,
        ];
    }
}
