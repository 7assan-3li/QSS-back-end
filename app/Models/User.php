<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\constant\ServiceType;
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
        'provider_policy',
        'no_commission',
        'commission',
        'bonus_points',
        'paid_points',
        'verification_provider',
        'provider_verified_until',
        'google_id',
        'avatar',
        'id_card',
        'id_card_hash',
        'rating_avg',
        'status',
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
            'provider_verified_until' => 'datetime',
            'verification_provider' => 'boolean',
        ];
    }

    public function isVerified()
    {
        if ($this->role !== 'provider') {
            return false;
        }

        if (!$this->verification_provider) {
            return false;
        }

        return is_null($this->provider_verified_until) || $this->provider_verified_until->isFuture();
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    public function main_services()
    {
        return $this->hasMany(Service::class, 'provider_id')
            ->whereNull('parent_service_id')->where('type', ServiceType::MAIN);
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

    public function hasExceededActiveRequestsLimit()
    {
        $activeCount = $this->requests()
            ->whereNotIn('status', [
                \App\constant\RequestStatus::COMPLETED,
                \App\constant\RequestStatus::CANCELLED,
                \App\constant\RequestStatus::REJECTED,
            ])
            ->count();
            
        return $activeCount >= 3;
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function authorizedCategories()
    {
        return $this->hasMany(ProviderCategory::class, 'user_id');
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

    public function getUnpaidCommissionsCount()
    {
        if ($this->role !== \App\constant\Role::PROVIDER) {
            return 0;
        }

        $cacheKey = 'unpaid_commissions_count_' . $this->id;
        
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(30), function () {
            $requests = \App\Models\Request::whereHas('main_service', function ($q) {
                    $q->where('provider_id', $this->id);
                })
                ->where('status', \App\constant\RequestStatus::COMPLETED)
                ->where('commission_paid', false)
                ->get();

            $count = 0;
            $defaultCommission = \App\Models\Setting::where('key', 'provider_commission')->value('value') ?? 10;

            foreach ($requests as $req) {
                $commissionAmount = $req->getCommissionAmount($this, $defaultCommission);
                
                if ($commissionAmount > 0 && $req->commission_amount_paid < $commissionAmount) {
                    $hasPendingBond = \App\Models\RequestCommissionBond::where('request_id', $req->id)
                        ->where('status', 'pending')
                        ->exists();
                        
                    if (!$hasPendingBond) {
                        $count++;
                    }
                }
            }

            return $count;
        });
    }
}
