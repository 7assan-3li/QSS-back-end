<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPointsPackage extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'status',
        'admin_id',
        'admin_note',
        'bond_image',
        'bond_number',
        'bank_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(PointsPackage::class, 'package_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
