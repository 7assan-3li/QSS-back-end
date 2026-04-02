<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraph(),
            'job_title' => $this->faker->jobTitle(),
            'latitude' => $this->faker->latitude(24.0, 25.0), // Around Riyadh area
            'longitude' => $this->faker->longitude(46.0, 47.0),
        ];
    }
}
