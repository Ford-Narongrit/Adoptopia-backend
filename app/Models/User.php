<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Notification;
use App\Models\PaymentHistory;
use App\Models\Adopt;
use App\Models\Trade;
use App\Models\DtaSug;
use App\Models\OtaSug;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class);
    }
    public function AdopHistories()
    {
        return $this->hasMany(AdopHistory::class);
    }
    
    public function adopt()
    {
        return $this->hasMany(Adopt::class);
    }

    public function trade()
    {
        return $this->hasMany(Trade::class);
    }

    public function dta_sug()
    {
        return $this->hasMany(DtaSug::class);
    }

    public function ota_sug()
    {
        return $this->hasMany(OtaSug::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name
        ];
    }
}
