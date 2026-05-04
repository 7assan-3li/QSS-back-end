<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSystemAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'account_number',
        'account_name',
        'is_active',
        'note',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the bank that owns the account.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
