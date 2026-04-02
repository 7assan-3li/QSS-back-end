<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousWork extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}