<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'points',
        'price',
        'bonus_points',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function userPackages()
    {
        return $this->hasMany(UserPointsPackage::class, 'package_id');
    }
}
