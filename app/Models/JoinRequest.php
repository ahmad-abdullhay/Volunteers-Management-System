<?php

namespace App\Models;

class JoinRequest extends BaseModel
{
    const STATUS_WAITING_FOR_HRM = 1;
    const STATUS_WAITING_FOR_HR_OFFICER = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_DECLINED = 4;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    protected $with = ['user', 'admin'];
}
