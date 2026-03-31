<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

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

    public function getActiveSchedule()
    {
        return $this->schedules()
            ->where('is_active', true)
            ->whereHas('days', function ($query) {
                $query->where('day', now()->format('l')); // l = full day name like Monday
            })
            ->first();
    }
}