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
        return $this->main_service()->first()?->provider;
    }

    public function getRequiredPartialAmount()
    {
        $percentage = $this->main_service()->first()?->required_partial_percentage ?? 0;
        return $this->total_price * ($percentage / 100);
    }



    public function bonds()
    {
        return $this->hasMany(RequestBond::class, 'request_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getCommissionAmount()
    {
        // إذا كان هناك مبلغ تم حسابه مسبقاً عند اكتمال الطلب، نستخدمه
        if ($this->commission_amount > 0) {
            return $this->commission_amount;
        }

        // بخلاف ذلك نحسبه بناءً على إجمالي الطلب ونسبة عمولة المزود
        $provider = $this->serviceProvider();
        if (!$provider || $provider->no_commission) {
            return 0;
        }

        $defaultCommission = \App\Models\Setting::where('key', 'provider_commission')->value('value') ?? 10;
        $percentage = $provider->commission ?? $defaultCommission;
        return $this->total_price * ($percentage / 100);
    }

    public function commissionBonds()
    {
        return $this->hasMany(RequestCommissionBond::class, 'request_id');
    }
}
