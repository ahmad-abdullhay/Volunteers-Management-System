<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Metric\MetricQuery;

class BadgeUser extends BaseModel
{

    protected $table = 'badge_user';

    protected $fillable = ['user_id', 'badge_id', 'note'];
    public function badge() {
        return $this->hasOne(Badge::class,'id','badge_id');
    }

}
