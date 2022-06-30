<?php

namespace App\Models\Metric;

use App\Models\BaseModel;
use App\Models\User;

class UserTotalPoints extends BaseModel
{

    protected $table = 'users_total_points';
   // protected $with = ['users'];
    protected $guarded = [];

//    public function users ()
//    {
//        return $this->hasOne(User::class);
//    }

}

