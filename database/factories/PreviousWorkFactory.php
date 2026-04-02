<?php

namespace Database\Factories;

use App\Models\PreviousWork;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreviousWorkFactory extends Factory
{
    protected $model = PreviousWork::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'image_path' => 'previous_works/default.png',
        ];
    }
}
