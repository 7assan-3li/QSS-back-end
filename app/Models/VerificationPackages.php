<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationPackages extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'description',
        'is_active',
    ];
}
