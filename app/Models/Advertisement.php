<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'type',
        'target_type',
        'target_id',
        'external_link',
        'user_type',
        'is_active',
        'sort_order',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Get the target model if it's a service or category.
     */
    public function getTargetAttribute()
    {
        if ($this->target_type === 'service') {
            return Service::find($this->target_id);
        }

        if ($this->target_type === 'category') {
            return Category::find($this->target_id);
        }

        return null;
    }

    /**
     * Scope for active advertisements.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('starts_at', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('ends_at')
                           ->orWhere('ends_at', '>=', now());
                     });
    }

    /**
     * Scope for specific user type.
     */
    public function scopeForUserType($query, $userType)
    {
        return $query->where(function ($q) use ($userType) {
            $q->where('user_type', 'all')
              ->orWhere('user_type', $userType);
        });
    }
}
