<?php

namespace App\Models;

use App\Models\Metric\MetricEventValue;
use App\Models\Metric\EventMetricConfiguration;
use App\Models\Metric\MetricEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metric extends BaseModel
{
    use HasFactory;

    const BOOLEAN_TYPE = 1;
    const BOOLEAN_LIST_TYPE = 2;
    const STRING_TYPE = 3;
    const STRING_LIST_TYPE = 4;
    const INTEGER_TYPE = 5;
    const INTEGER_LIST_TYPE = 6;
    const ENUM_TYPE = 7;
    const ENUM_LIST_TYPE = 8;

    protected $guarded = [];
    protected $with =['metricEnum'];
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function configuration()
    {
        return $this->belongsTo(EventMetricConfiguration::class,'id','metric_id');
    }
    public function metricEnum ()
    {
        return $this->hasMany(MetricEnum::class);
    }

    public function isList($type){
        return $type == Metric::BOOLEAN_LIST_TYPE ||
            $type == Metric::STRING_LIST_TYPE ||
            $type == Metric::INTEGER_LIST_TYPE ||
            $type == Metric::ENUM_LIST_TYPE;
    }

    public function values()
    {
        return $this->hasMany(MetricEventValue::class, 'metric_id');
    }
}
