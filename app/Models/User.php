<?php

namespace App\Models;


use App\Models\Metric\UserPoint;
use App\Models\Metric\UserTotalPoints;
use App\Services\BadgeService;

use App\Filters\User\StatusFilter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail;

    const ACTIVE_STATUS = 1;
    const INACTIVE_STATUS = 0;

    protected $guarded = [];


    protected array $filterables = [
        StatusFilter::class
    ];
    protected $with = ['totalPoints'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function joinRequest()
    {
        return $this->hasOne(JoinRequest::class, 'user_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }
    public function totalPoints ()
    {
        return $this->hasOne(UserTotalPoints::class);
    }
}
