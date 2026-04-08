<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Category;
use App\Models\Bank;
use App\Models\VerificationPackages;
use App\Models\ProfilePhone;
use App\Models\PreviousWork;
use App\Models\Request as ServiceRequest;
use App\Models\Review;
use App\constant\Role;
use App\constant\RequestStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DetailedProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Detailed Provider Seeder...');

        // 1. Ensure a Category exists
        $category = Category::first() ?? Category::create([
            'name' => 'الخدمات التقنية',
            'description' => 'البرمجة والتطوير والدعم الفني',
            'is_active' => true,
        ]);

        // 2. Ensure a Bank exists
        $bank = Bank::first() ?? Bank::create([
            'name' => 'بنك التضامن',
        ]);

        // 3. Ensure Verification Package exists
        $package = VerificationPackages::first() ?? VerificationPackages::create([
            'name' => 'باقة المزايا الفضية',
            'price' => 5000,
            'duration_days' => 30,
            'description' => 'توثيق الحساب وظهور في النتائج الأولى',
            'is_active' => true,
        ]);

        // 4. Create Main Showcase Provider
        $email = 'showcase@qss.com';
        User::where('email', $email)->delete();

        $provider = User::create([
            'name' => 'م. أحمد العلي (مزود نموذجي)',
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => Role::PROVIDER,
            'email_verified_at' => now(),
            'commission' => 8, // Special commission rate
            'provider_verified_until' => now()->addMonths(6),
        ]);

        $this->command->info("Created provider: {$provider->name}");

        // 5. Create Profile
        $profile = Profile::create([
            'user_id' => $provider->id,
            'job_title' => 'مطور تطبيقات موبايل ومواقع ويب',
            'bio' => 'خبير في تطوير تطبيقات الـ Cross-platform وتطبيقات الويب باستخدام Laravel و Flutter. خبرة أكثر من 5 سنوات في السوق المحلية والدولية. ملتزم بتقديم أعلى معايير الجودة والأداء.',
            'latitude' => 15.3694,
            'longitude' => 44.1910,
        ]);

        // 6. Create Profile Phones
        ProfilePhone::create([
            'profile_id' => $profile->id,
            'phone' => '777123456',
            'country_code' => '967',
            'type' => 'mobile',
            'is_primary' => true,
            'is_active' => true,
        ]);
        ProfilePhone::create([
            'profile_id' => $profile->id,
            'phone' => '711987654',
            'country_code' => '967',
            'type' => 'work',
            'is_primary' => false,
            'is_active' => true,
        ]);

        // 7. Create Previous Works (Portfolio)
        PreviousWork::create([
            'profile_id' => $profile->id,
            'title' => 'تطبيق متجر إلكتروني متكامل',
            'description' => 'تطوير تطبيق متجر إلكتروني يدعم الدفع عند الاستلام وإدارة المخزون.',
            'image_path' => 'demo/work1.jpg',
        ]);
        PreviousWork::create([
            'profile_id' => $profile->id,
            'title' => 'منظومة إدارة المختبرات الطبية',
            'description' => 'نظام سحابي لإدارة السجلات الطبية والنتائج الآلية.',
            'image_path' => 'demo/work2.jpg',
        ]);

        // 8. Create Services
        $services = [
            [
                'name' => 'تطوير موقع تعريفي احترافي',
                'description' => 'كتابة كود نظيف وتصميم متوافق مع كافة الشاشات.',
                'price' => 25000,
            ],
            [
                'name' => 'برمجة تطبيق أندرويد و iOS',
                'description' => 'استخدام Flutter لبناء تطبيق يعمل على المنصتين.',
                'price' => 85000,
            ],
            [
                'name' => 'تحليل وتحسين أداء قواعد البيانات',
                'description' => 'تسريع الاستعلامات وضمان سلامة البيانات.',
                'price' => 15000,
            ],
        ];

        foreach ($services as $sData) {
            Service::create(array_merge($sData, [
                'provider_id' => $provider->id,
                'category_id' => $category->id,
                'type' => 'remote',
                'is_active' => true,
            ]));
        }

        // 9. Attach Bank
        $provider->banks()->attach($bank->id, [
            'bank_account' => '123456789012345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 10. Attach Verification Package
        $provider->verificationPackages()->attach($package->id, [
            'status' => 'approved',
            'image_bond' => 'demo/bond.jpg',
            'number_bond' => '100200300',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 11. Create Feedback Ecosystem (Reviews)
        $seeker = User::where('role', Role::SEEKER)->first() ?? User::create([
            'name' => 'العميل التجريبي (خالد)',
            'email' => 'seeker_demo@qss.com',
            'password' => Hash::make('password'),
            'role' => Role::SEEKER,
            'email_verified_at' => now(),
        ]);

        $feedback = [
            ['rating' => 5, 'comment' => 'عمل ممتاز واحترافي، أنصح بشدة بالتعامل معه.'],
            ['rating' => 4, 'comment' => 'سرعة في التنفيذ وتواصل ممتاز.'],
            ['rating' => 5, 'comment' => 'دقة في المواعيد وجودة برمجية عالية.'],
        ];

        foreach ($feedback as $f) {
            // Create a completed request
            $request = ServiceRequest::create([
                'user_id' => $seeker->id,
                'status' => RequestStatus::COMPLETED,
                'total_price' => rand(10000, 30000),
                'commission_amount' => 1500,
                'latitude' => 15.35,
                'longitude' => 44.20,
                'address' => 'صنعاء، حي حدة',
                'created_at' => now()->subDays(rand(1, 10)),
            ]);

            // Link to one of the provider's services
            $request->services()->attach($provider->services->random()->id, [
                'quantity' => 1,
                'is_main' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create review
            Review::create([
                'request_id' => $request->id,
                'rating' => $f['rating'],
                'comment' => $f['comment'],
            ]);
        }

        $this->command->info('Detailed Provider Seeder finished successfully!');
    }
}
