<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemComplaint extends Model
{
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include complaints from the seeker app.
     */
    public function scopeSeeker($query)
    {
        return $query->where('app_source', 'seeker');
    }

    /**
     * Scope a query to only include complaints from the provider app.
     */
    public function scopeProvider($query)
    {
        return $query->where('app_source', 'provider');
    }
}
