<?php

namespace App\Models\Metric;

use App\Models\BaseModel;
use App\Models\Level;
use App\Models\Metric;

class EventPointStats extends BaseModel
{
    protected $table = 'events_points_stats';
    protected $guarded = [];
    protected $appends = ['basedLevels','nextLevel'];
    public function getBasedLevelsAttribute ()
    {
        return Level::whereBetween ('min_points',[$this->points_before,$this->points_before+$this->points_added])->get();
    }

    public function getNextLevelAttribute ()
    {
        return  Level::orderBy('min_points','ASC')->where('min_points','>',$this->points_before+$this->points_added)-> first();
    }


}
