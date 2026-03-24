<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationPackagesImage extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(UserVerificationPackages::class, 'package_id');
    }
}
