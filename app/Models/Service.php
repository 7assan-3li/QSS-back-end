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
    
}