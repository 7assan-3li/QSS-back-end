<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleServiceDay extends Model
{
    protected $guarded = ['id'];

    public function schedule()
    {
        return $this->belongsTo(ScheduleService::class, 'schedule_service_id');
    }
}
