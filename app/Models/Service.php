<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($service) {
            $service->setAllTimeAvailability();
        });
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // الخدمة الأب
    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_service_id');
    }

    // الخدمات الأبناء
    public function children()
    {
        return $this->hasMany(Service::class, 'parent_service_id');
    }

    public function requests()
    {
        return $this->belongsToMany(Request::class, 'request_service', 'service_id', 'request_id')
                    ->withPivot(['quantity','is_main'])
                    ->withTimestamps();
    }

    public function main_service(){
        return $this->belongsToMany(Request::class, 'request_service', 'service_id', 'request_id')
                    ->wherePivot('is_main', true)
                    ->withTimestamps();
    }

    public function getRequiredPartialAmount()
    {
        $percentage = $this->required_partial_percentage ?? 0;
        return $this->price * ($percentage / 100);
    }

    public function schedules()
    {
        return $this->hasMany(ScheduleService::class);
    }

    /**
     * التحقق مما إذا كانت الخدمة متاحة في الوقت الحالي بناءً على الجدول الزمني
     */
    public function isAvailableNow()
    {
        $dayName = strtolower(now()->format('l')); // يجلب اسم اليوم (monday, sunday, etc.)
        $currentTime = now()->format('H:i:s');

        return $this->schedules()
            ->where('is_active', true)
            ->whereHas('days', function ($query) use ($dayName) {
                $query->where('day', $dayName);
            })
            ->whereTime('start_time', '<=', $currentTime)
            ->whereTime('end_time', '>=', $currentTime)
            ->exists();
    }

    /**
     * إعداد الخدمة لتكون متاحة طوال الوقت (24/7)
     */
    public function setAllTimeAvailability()
    {
        return DB::transaction(function () {
            // إنشاء الفترة الزمنية الرئيسية (24 ساعة)
            $schedule = $this->schedules()->create([
                'label'      => 'متاح دائماً (24/7)',
                'start_time' => '00:00:00',
                'end_time'   => '23:59:59',
                'is_active'  => true,
            ]);

            // ربطها بجميع الأيام السبعة
            foreach (\App\constant\Days::all() as $day) {
                $schedule->days()->create(['day' => $day]);
            }

            return $schedule;
        });
    }

    public function getActiveSchedule()
    {
        $dayName = strtolower(now()->format('l'));
        $currentTime = now()->format('H:i:s');

        return $this->schedules()
            ->where('is_active', true)
            ->whereHas('days', function ($query) use ($dayName) {
                $query->where('day', $dayName);
            })
            ->whereTime('start_time', '<=', $currentTime)
            ->whereTime('end_time', '>=', $currentTime)
            ->first();
    }
}