<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = ['name','handphone','email', 'password','referral_code', 'referred_by','upline_id','balance','created_at'];
    
    public function isAdmin()
    {
        return $this->role === 'admin'; // Asumsikan ada kolom 'role' di tabel users
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function referralBonuses()
    {
        return $this->hasMany(ReferralBonus::class);
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function rekenings()
    {
        return $this->hasOne(Rekening::class);
    }
}
