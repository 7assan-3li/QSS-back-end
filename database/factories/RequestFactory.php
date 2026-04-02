<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_price' => $this->faker->randomFloat(2, 100, 5000),
            'money_paid' => $this->faker->randomFloat(2, 0, 1000),
            'commission_paid' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'completed', 'canceled']),
            'message' => $this->faker->sentence(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'address' => $this->faker->address(),
            'bonus_points_awarded' => $this->faker->boolean(),
            'commission_amount' => $this->faker->randomFloat(2, 10, 500),
            'commission_amount_paid' => $this->faker->randomFloat(2, 0, 500),
            'commission_paid_status' => $this->faker->boolean(),
        ];
    }
}
