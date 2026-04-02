<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use App\constant\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 50, 5000),
            'category_id' => Category::factory(),
            'provider_id' => User::factory(),
            'type' => ServiceType::MAIN,
            'status' => 'available',
            'is_available' => true,
            'is_active' => true,
            'required_partial_percentage' => $this->faker->randomElement([0, 10, 20, 50]),
        ];
    }
}
