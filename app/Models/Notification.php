<?php

namespace App\Models;

use App\Filters\Notification\StatusFilter;
use App\Filters\Notification\UserFilter;

class Notification extends BaseModel
{
    const STATUS_NOT_READ = 0;
    const STATUS_READ = 1;

    const NOTIFICATION_USER_TYPE = 1 ;
    const NOTIFICATION_EVENT_TYPE = 2 ;
    const NOTIFICATION_BADGE_TYPE = 3 ;


    protected $guarded = [];

    protected $appends = ['reasonableNumberType'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected array $filterables = [
        UserFilter::class,
        StatusFilter::class
    ];

    public function reasonable()
    {
        return $this->morphTo();
    }

    protected $with = ['reasonable'];

    protected function getReasonableNumberTypeAttribute()
    {
        return config('notification.class_to_type.' . $this->reasonable_type);
    }
}
