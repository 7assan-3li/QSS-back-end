<?php

namespace Database\Seeders;

use App\constant\Role;
use App\Models\Category;
use App\Models\User;
use App\Models\Bank;
use App\Models\VerificationPackages;
use App\Models\PointsPackage;
use App\Models\Request;
use App\Models\Review;
use App\Models\Service;
use App\Models\Profile;
use App\Models\ProfilePhone;
use App\Models\PreviousWork;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'ادمن النظام',
                'password' => Hash::make('12345678'),
                'role' => Role::ADMIN,
                'seeker_policy' => true,
                'email_verified_at' => now()
            ]
        );
        $admin->profile()->updateOrCreate(['user_id' => $admin->id], []);
        //seeker
        $seeker = User::updateOrCreate(
            ['email' => 'seeker@gmail.com'],
            [
                'name' => 'طالب الخدمة',
                'password' => Hash::make('12345678'),
                'role' => Role::SEEKER,
                'seeker_policy' => true,
                'email_verified_at' => now()
            ]
        );
        $seeker->profile()->updateOrCreate(['user_id' => $seeker->id], []);
        //provider
        $provider = User::updateOrCreate(
            ['email' => 'provider@gmail.com'],
            [
                'name' => 'مزود الخدمة',
                'password' => Hash::make('12345678'),
                'role' => Role::PROVIDER,
                'seeker_policy' => true,
                'email_verified_at' => now()
            ]
        );
        $provider->profile()->updateOrCreate(['user_id' => $provider->id], []);

        // 2. Hierarchical Categories
        $categories = [
            'صيانة منزلية' => ['سباكة', 'كهرباء', 'تكييف'],
            'تكنولوجيا' => ['برمجة تطبيقات', 'تصميم جرافيك', 'صيانة حاسب'],
            'مركبات' => ['ميكانيك', 'سمكرة ودهاء', 'غسيل متنقل'],
            'خدمات طبية' => ['تمريض منزلي', 'علاج طبيعي'],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName],
                ['description' => "خدمات متخصصة في " . $parentName]
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName],
                    [
                        'description' => "متخصصون في " . $childName,
                        'category_id' => $parent->id
                    ]
                );
            }
        }

        $allCategories = Category::all();

        // 3. Providers (10)
        $providers = User::factory(10)->create([
            'role' => Role::PROVIDER,
            'password' => Hash::make('12345678'),
            'seeker_policy' => true,
        ]);

        foreach ($providers as $provider) {
            // Profile
            $profile = Profile::factory()->create([
                'user_id' => $provider->id,
                'job_title' => 'مزود خدمة محترف',
            ]);

            // Phones (2 per provider)
            ProfilePhone::factory(2)->create([
                'profile_id' => $profile->id
            ]);

            // Previous Work (2 per provider)
            PreviousWork::factory(2)->create([
                'profile_id' => $profile->id
            ]);

            // Services (3 per provider)
            Service::factory(3)->create([
                'provider_id' => $provider->id,
                'category_id' => $allCategories->random()->id
            ]);
        }

        // 4. Seekers (10)
        $seekers = User::factory(10)->create([
            'role' => Role::SEEKER,
            'password' => Hash::make('12345678'),
            'seeker_policy' => true,
        ]);

        foreach ($seekers as $seeker) {
            $seeker->profile()->create([
                'bio' => 'طالب خدمة في النظام',
            ]);
        }

        // 5. Banks (Standard Saudi Banks)
        $saudiBanks = ['مصرف الراجحي', 'البنك الأهلي السعودي', 'بنك الرياض', 'مصرف الإنماء', 'بنك البلاد'];
        foreach ($saudiBanks as $bankName) {
            Bank::firstOrCreate(['bank_name' => $bankName]);
        }
        $allBanks = Bank::all();

        // 6. Verification Packages
        $vPackages = [
            ['name' => 'مزود موثوق', 'price' => 99.00, 'duration_days' => 30, 'description' => 'باقة التوثيق الأساسية للمزودين'],
            ['name' => 'الباقة الاحترافية', 'price' => 249.00, 'duration_days' => 90, 'description' => 'توثيق متقدم مع ميزات إضافية'],
            ['name' => 'العضوية السنوية', 'price' => 799.00, 'duration_days' => 365, 'description' => 'أفضل خيار سنوي للمحترفين'],
        ];
        foreach ($vPackages as $vp) {
            VerificationPackages::firstOrCreate(['name' => $vp['name']], $vp);
        }
        $allVPackages = VerificationPackages::all();

        // 7. Points Packages
        $pPackages = [
            ['name' => 'باقة 50 نقطة', 'points' => 50, 'price' => 10.00, 'bonus_points' => 0],
            ['name' => 'باقة 250 نقطة', 'points' => 250, 'price' => 45.00, 'bonus_points' => 20],
            ['name' => 'باقة 1000 نقطة', 'points' => 1000, 'price' => 150.00, 'bonus_points' => 100],
        ];
        foreach ($pPackages as $pp) {
            PointsPackage::firstOrCreate(['name' => $pp['name']], $pp);
        }
        $allPPackages = PointsPackage::all();

        // 8. Link Providers to Banks and Packages
        foreach ($providers as $provider) {
            // Attach random bank
            $provider->banks()->attach($allBanks->random()->id, [
                'bank_account' => 'SA' . fake()->numerify('######################'),
            ]);

            // Randomly verify some providers
            if (fake()->boolean(70)) {
                $provider->verificationPackages()->attach($allVPackages->random()->id, [
                    'image_bond' => 'bonds/fake_bond.jpg',
                    'number_bond' => fake()->numerify('BND-######'),
                    'status' => 'approved',
                    'admin_id' => $admin->id,
                ]);
            }
        }

        // 9. Generate Service Requests (20 Requests)
        for ($i = 0; $i < 20; $i++) {
            $seeker = $seekers->random();
            $provider = $providers->random();
            $pServices = $provider->services;

            if ($pServices->isEmpty()) continue;

            $mainService = $pServices->random();
            
            $request = Request::create([
                'user_id' => $seeker->id,
                'total_price' => $mainService->price,
                'status' => fake()->randomElement(['pending', 'accepted', 'completed', 'canceled']),
                'message' => fake()->sentence(),
                'latitude' => $seeker->profile->latitude,
                'longitude' => $seeker->profile->longitude,
                'address' => fake()->address(),
            ]);

            // Link in pivot
            $request->services()->attach($mainService->id, [
                'quantity' => 1,
                'is_main' => true,
            ]);

            // 10. Generate Reviews for completed requests
            if ($request->status === 'completed') {
                Review::create([
                    'request_id' => $request->id,
                    'rating' => fake()->numberBetween(3, 5),
                    'comment' => fake()->sentence(),
                ]);
            }
        }

        echo "Seed complete: Banks, Packages, Requests, and Reviews populated.\n";
    }
}
