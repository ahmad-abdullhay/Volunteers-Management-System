<?php

namespace App\Models;

use App\Models\BaseModel;

class BadgeUser extends BaseModel
{

    protected $table = 'badge_user';

    protected $fillable = ['user_id', 'badge_id', 'note'];

}
