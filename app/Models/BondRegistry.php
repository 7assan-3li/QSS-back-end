<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BondRegistry extends Model
{
    protected $fillable = [
        'bond_number',
        'bank_name',
        'amount',
        'user_id',
        'source_type',
        'source_id',
        'image_hash',
        'status',
    ];}
