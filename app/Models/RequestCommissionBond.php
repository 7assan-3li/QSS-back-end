<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCommissionBond extends Model
{
    protected $guarded = ['id'];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}