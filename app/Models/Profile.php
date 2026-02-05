<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function previousWorks()
    {
        return $this->hasMany(PreviousWork::class, 'profile_id');
    }
    public function profilePhones()
    {
        return $this->hasMany(ProfilePhone::class, 'profile_id');
    }
}