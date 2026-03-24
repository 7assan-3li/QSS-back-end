<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $guarded = ['id'];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
