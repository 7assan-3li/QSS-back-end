<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderRequest extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'admin_id',
        'status',
        'requestContent',
        'id_card',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
