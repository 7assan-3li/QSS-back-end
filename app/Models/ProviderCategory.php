<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderCategory extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'max_services',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_services' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
