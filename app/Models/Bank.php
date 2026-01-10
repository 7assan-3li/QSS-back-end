<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_bank', 'user_id', 'bank_id')
            ->withPivot(['bank_account'])
            ->withTimestamps();
    }
}