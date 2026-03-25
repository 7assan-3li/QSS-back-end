<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
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

    public function commissionBonds()
    {
        return $this->hasMany(RequestCommissionBond::class, 'request_id');
    }
}
