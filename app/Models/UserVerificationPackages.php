<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationPackages extends Model
{
    protected $fillable = [
        'user_id',
        'verification_package_id',
        'number_bond',
        'status',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verificationPackage()
    {
        return $this->belongsTo(VerificationPackages::class, 'verification_package_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function images()
    {
        return $this->hasMany(UserVerificationPackagesImage::class, 'package_id');
    }
}
