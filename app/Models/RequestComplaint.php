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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include complaints made by the seeker of the request.
     */
    public function scopeSeeker($query)
    {
        return $query->whereHas('request', function ($q) {
            $q->whereColumn('user_id', 'request_complaints.user_id');
        });
    }

    /**
     * Scope a query to only include complaints made by the provider of the request.
     */
    public function scopeProvider($query)
    {
        return $query->whereHas('request.services', function ($q) {
            $q->whereColumn('services.provider_id', 'request_complaints.user_id');
        });
    }
}
