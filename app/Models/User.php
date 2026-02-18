<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'username',
        'referral_code',
        'referred_by',
        'password',
        'is_verified',
        'balance',
        'coins_balance',
        'status',
        'is_admin',
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
            'is_verified' => 'boolean',
            'balance' => 'decimal:2',
            'coins_balance' => 'decimal:2',
        ];
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function userContracts()
    {
        return $this->hasMany(UserContract::class);
    }

    public function activeContracts()
    {
        return $this->userContracts()
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }
}
