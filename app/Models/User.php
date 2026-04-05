<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailForMobile;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'seeker_policy',
        'no_commission',
        'commission',
        'bonus_points',
        'paid_points',
        'verification_provider',
        'provider_verified_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    public function main_services()
    {
        return $this->hasMany(Service::class, 'provider_id')
            ->whereNull('parent_service_id');
    }

    public function banks()
    {
        return $this->belongsToMany(Bank::class, 'user_bank', 'user_id', 'bank_id')
            ->withPivot(['bank_account'])
            ->withTimestamps();
    }

    public function providerRequests()
    {
        return $this->hasMany(ProviderRequest::class, 'user_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'user_id');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class, 'user_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailForMobile());
    }

    public function favoriteServices()
    {
        return $this->belongsToMany(Service::class, 'favorite_services', 'user_id', 'service_id')
                    ->withTimestamps();
    }

    public function verificationPackages()
    {
        return $this->belongsToMany(VerificationPackages::class, 'user_verification_packages', 'user_id', 'verification_package_id')
            ->withPivot(['id', 'image_bond', 'number_bond', 'status', 'admin_id'])
            ->withTimestamps();
    }
}
