<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestComplaint extends Model
{
    protected  $guarded = ['id'];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
