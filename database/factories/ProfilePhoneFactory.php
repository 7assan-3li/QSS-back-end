<?php

namespace Database\Factories;

use App\Models\ProfilePhone;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilePhoneFactory extends Factory
{
    protected $model = ProfilePhone::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'phone' => $this->faker->numerify('#########'),
            'country_code' => '+966',
            'type' => $this->faker->randomElement(['mobile', 'whatsapp', 'both']),
            'is_primary' => false,
            'is_active' => true,
        ];
    }
}
