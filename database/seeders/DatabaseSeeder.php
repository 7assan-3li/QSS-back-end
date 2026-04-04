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

            if ($pServices->isEmpty())
                continue;

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

        // 11. System Complaints
        for ($i = 0; $i < 10; $i++) {
            $user = fake()->boolean() ? $seekers->random() : $providers->random();
            $appSource = $user->role === Role::SEEKER ? 'seeker' : 'provider';
            \App\Models\SystemComplaint::create([
                'title' => fake()->sentence(4),
                'content' => fake()->paragraph(),
                'type' => fake()->randomElement(['مشكلة تقنية', 'اقتراح', 'استفسار مالي', 'أخرى']),
                'user_id' => $user->id,
                'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
                'app_source' => $appSource,
            ]);
        }

        // 12. Request Complaints
        $requests = Request::all();
        foreach ($requests->random(min(5, $requests->count())) as $r) {
            // Complaint could be from Seeker or Provider
            $providerId = $r->services->first() ? $r->services->first()->provider_id : null;
            $complainantId = (fake()->boolean() && $providerId) ? $providerId : $r->user_id;

            \App\Models\RequestComplaint::create([
                'title' => 'شكوى بخصوص الطلب ' . $r->id,
                'type' => fake()->randomElement(['تأخير', 'جودة الخدمة', 'عدم الالتزام', 'أخرى']),
                'content' => fake()->paragraph(),
                'request_id' => $r->id,
                'user_id' => $complainantId,
                'status' => fake()->randomElement(['pending', 'in_progress', 'resolved']),
            ]);
        }

        // 13. Provider Requests
        for ($i = 0; $i < 5; $i++) {
            \App\Models\ProviderRequest::create([
                'name' => 'طلب انضمام: ' . fake()->name(),
                'user_id' => $seekers->random()->id,
                'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
                'requestContent' => 'أرغب بالانضمام لمنصتكم كمزود خدمة محترف',
                'id_card' => 'bonds/fake_id.jpg',
                'location' => fake()->address(),
            ]);
        }

        // 14. User Points Packages
        foreach ($seekers->random(5) as $user) {
            \App\Models\UserPointsPackage::create([
                'user_id' => $user->id,
                'package_id' => $allPPackages->random()->id,
                'bond_number' => 'BND' . fake()->numerify('######'),
                'bond_image' => 'bonds/fake_bond.jpg',
                'bank_name' => fake()->randomElement(['مصرف الراجحي', 'البنك الأهلي', 'بنك الرياض']),
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            ]);
        }

        // 15. Withdraw Requests
        foreach ($providers->random(5) as $provider) {
            \App\Models\WithdrawRequest::create([
                'user_id' => $provider->id,
                'amount' => fake()->randomFloat(2, 100, 1000),
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            ]);
        }

        // 16. Financial Bonds
        foreach ($requests->random(min(3, $requests->count())) as $r) {
            \App\Models\RequestBond::create([
                'request_id' => $r->id,
                'image_path' => 'bonds/fake_bond.jpg',
                'amount' => $r->total_price ?? 50.00,
            ]);
        }

        foreach ($requests->random(min(3, $requests->count())) as $r) {
            \App\Models\RequestCommissionBond::create([
                'request_id' => $r->id,
                'bond_number' => fake()->numerify('######'),
                'image_path' => 'bonds/fake_bond.jpg',
                'amount' => fake()->randomFloat(2, 50, 200),
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            ]);
        }

        // 17. Favorite Services
        $allServices = \App\Models\Service::all();
        if ($allServices->isNotEmpty()) {
            foreach ($seekers->random(5) as $seeker) {
                \App\Models\FavoriteService::firstOrCreate([
                    'user_id' => $seeker->id,
                    'service_id' => $allServices->random()->id,
                ]);
            }
        }

        // 18. Point Transactions
        foreach ($providers->random(3) as $provider) {
            \App\Models\PointTransaction::create([
                'provider_id' => $provider->id,
                'amount' => fake()->numberBetween(10, 100),
                'type' => fake()->randomElement(['commission_deduction', 'withdrawal', 'bonus']),
            ]);
        }

        echo "Seed complete: Banks, Packages, Requests, Reviews, Complaints, and Finances populated.\n";
    }
}
