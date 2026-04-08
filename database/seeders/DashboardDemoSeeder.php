<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Request as ServiceRequest;
use App\Models\Service;
use App\constant\Role;
use App\constant\RequestStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        // تنظيف البيانات الوهمية القديمة لتجنب تكرار البريد الإلكتروني
        User::where('email', 'like', 'provider_demo_%')->delete();
        ServiceRequest::where('address', 'like', 'Street in %')->delete();

        // المدن الرئيسية في اليمن وإحداثياتها
        $cities = [
            ['name' => 'Sana\'a', 'lat' => 15.3694, 'lng' => 44.1910],
            ['name' => 'Aden', 'lat' => 12.7855, 'lng' => 45.0186],
            ['name' => 'Taiz', 'lat' => 13.5783, 'lng' => 44.0125],
            ['name' => 'Ibb', 'lat' => 13.9740, 'lng' => 44.1706],
            ['name' => 'Hodeidah', 'lat' => 14.7979, 'lng' => 42.9530],
        ];

        $this->command->info('Generating fake providers across Yemen...');

        // التأكد من وجود قسم (Category) واحد على الأقل
        $category = \App\Models\Category::first() ?? \App\Models\Category::create(['name' => 'General Services']);

        // 1. توليد مزودي خدمات
        for ($i = 1; $i <= 15; $i++) {
            $city = $cities[array_rand($cities)];
            
            $provider = User::create([
                'name' => "Provider " . fake()->name(),
                'email' => "provider_demo_{$i}@qss.com",
                'password' => Hash::make('password'),
                'role' => Role::PROVIDER,
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id' => $provider->id,
                'bio' => fake()->paragraph(),
                'job_title' => fake()->jobTitle(),
                'latitude' => $city['lat'] + (mt_rand(-50, 50) / 1000),
                'longitude' => $city['lng'] + (mt_rand(-50, 50) / 1000),
            ]);

            // إضافة خدمة تجريبية للمزود لضمان ظهور البيانات في الإحصائيات
            Service::create([
                'provider_id' => $provider->id,
                'category_id' => $category->id,
                'name' => 'خدمة تجريبية ' . $i,
                'description' => 'وصف خدمة تجريبية',
                'price' => rand(5000, 50000),
                'type' => 'meeting',
                'is_active' => true,
            ]);
        }

        $this->command->info('Generating intense request density for heatmap...');

        // 2. توليد طلبات مكثفة لإنشاء الحرارة الجغرافية
        $seekers = User::where('role', Role::SEEKER)->limit(10)->get();
        if ($seekers->isEmpty()) {
            $seekers = [User::first()];
        }
        
        $statuses = [RequestStatus::COMPLETED, RequestStatus::PENDING, RequestStatus::CANCELLED];

        for ($i = 1; $i <= 100; $i++) {
            $city = $cities[array_rand($cities)];
            $status = $statuses[array_rand($statuses)];
            
            $price = rand(1000, 20000);
            $commission = $price * 0.1;

            ServiceRequest::create([
                'user_id' => $seekers->random()->id ?? 1,
                'status' => $status,
                'total_price' => $price,
                'commission_amount' => $commission,
                'latitude' => $city['lat'] + (mt_rand(-150, 150) / 1000), // تشتت أوسع للطلبات لتمثيل غطاس المنطقة
                'longitude' => $city['lng'] + (mt_rand(-150, 150) / 1000),
                'address' => "Street in " . $city['name'],
                'created_at' => now()->subDays(rand(0, 60)), // توزيع زمن الطلبات لآخر شهرين
            ]);
        }

        $this->command->info('Dashboard Demo Data seeded successfully!');
    }
}
