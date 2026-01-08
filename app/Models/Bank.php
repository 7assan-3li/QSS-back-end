<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(Request::class, 'user_bank', 'bank_id', 'bank_id')
            ->withPivot(['bank_account'])
            ->withTimestamps();
    }
}
