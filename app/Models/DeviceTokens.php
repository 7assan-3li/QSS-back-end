<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceTokens extends Model
{
    protected $fillable = ['user_id', 'token'];

    // If you want to define the relationship to User:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
