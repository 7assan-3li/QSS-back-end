<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts = [
        'bonus_points_awarded' => 'boolean',
        'provider_finished' => 'boolean',
    ];

    // public function service()
    // {
    //     return $this->belongsTo(Service::class, 'service_id');
    // }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'request_service', 'request_id', 'service_id')
            ->withPivot(['quantity', 'is_main'])
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function main_service()
    {
        return $this->belongsToMany(Service::class, 'request_service', 'request_id', 'service_id')
            ->withPivot(['quantity', 'is_main'])
            ->wherePivot('is_main', true)
            ->withTimestamps();
    }

    public function sub_services()
    {
        return $this->belongsToMany(Service::class, 'request_service', 'request_id', 'service_id')
            ->withPivot(['quantity', 'is_main'])
            ->wherePivot('is_main', false)
            ->withTimestamps();
    }

    public function serviceProvider()
    {
        // استخدام العلاقة المحملة مسبقاً إذا كانت موجودة لتجنب N+1 queries
        $mainService = $this->relationLoaded('main_service') ? $this->main_service->first() : $this->main_service()->first();
        return $mainService?->provider;
    }

    public function getRequiredPartialAmount()
    {
        $mainService = $this->relationLoaded('main_service') ? $this->main_service->first() : $this->main_service()->first();
        $percentage = $mainService?->required_partial_percentage ?? 0;
        return (float) ($this->total_price * ($percentage / 100));
    }



    public function bonds()
    {
        return $this->hasMany(RequestBond::class, 'request_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getCommissionAmount($provider = null, $defaultPercentage = null)
    {
        // إذا كان هناك مبلغ تم حسابه مسبقاً، نستخدمه لضمان ثبات البيانات
        if ($this->commission_amount > 0) {
            return (float) $this->commission_amount;
        }

        // بخلاف ذلك نحسبه بناءً على إجمالي الطلب ونسبة عمولة المزود
        $provider = $provider ?? $this->serviceProvider();
        if (!$provider || $provider->no_commission) {
            $this->commission_rate = 0;
            return 0.0;
        }

        if ($defaultPercentage === null) {
            $defaultPercentage = \App\Models\Setting::where('key', 'provider_commission')->value('value') ?? 10;
        }
        
        // إذا كانت عمولة المزود 0، نستخدم العمولة الافتراضية للنظام
        // إلا إذا كان لديه استثناء يدوي عبر no_commission (تم معالجته أعلاه)
        $percentage = ($provider->commission > 0) ? $provider->commission : $defaultPercentage;
        
        // تخرين النسبة المستخدمة في خاصية الموديل لكي يتم حفظها عند عمل save()
        $this->commission_rate = (float) $percentage;
        
        return (float) ($this->total_price * ($percentage / 100));
    }

    public function commissionBonds()
    {
        return $this->hasMany(RequestCommissionBond::class, 'request_id');
    }
}
