<?php

namespace App\Models;

class EventUser extends BaseModel
{
    const NOT_SUPERVISOR = 0;
    const SUPERVISOR = 1;

    const REJECTED_STATUS = 0;
    const ACCEPTED_STATUS = 1;
    const PENDING_STATUS = 2;

    protected $table = 'event_user';

    protected $fillable = ['user_id', 'event_id', 'status', 'is_supervisor'];

}
