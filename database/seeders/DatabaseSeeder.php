<?php

namespace Database\Seeders;

use App\constant\Role;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => Role::ADMIN,
            'seeker_policy' => true,
            'email_verified_at' => now()
        ]);

        $admin->profile()->create([
        ]);

       
        $user1 = User::factory()->create([
            'name' => 'seeker',
            'email' => 'seeker@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => Role::SEEKER,
            'seeker_policy' => true,
            'email_verified_at' => now()
        ]);

        $user1->profile()->create([
        ]);

        
        $user2 = User::factory()->create([
            'name' => 'provider',
            'email' => 'provider@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => Role::PROVIDER,
            'seeker_policy' => true,
            'email_verified_at' => now()
        ]);

        $user2->profile()->create([
        ]);

        Category::factory()->create([
            'name' => 'category 1',
            'description' => 'description for category 1'
        ]);

        // Category::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
