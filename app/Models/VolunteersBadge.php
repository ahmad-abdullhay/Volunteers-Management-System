<?php

namespace App\Models;

class VolunteersBadge extends BaseModel
{

    protected $table = 'volunteers_badges';

    protected $fillable = ['user_id', 'badge_id', 'notes'];

}
