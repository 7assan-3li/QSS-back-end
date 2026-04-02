<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationPackages extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'description',
        'is_active',
    ];
}
