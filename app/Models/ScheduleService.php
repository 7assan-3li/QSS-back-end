<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleService extends Model
{
    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function days()
    {
        return $this->hasMany(ScheduleServiceDay::class);
    }
}
