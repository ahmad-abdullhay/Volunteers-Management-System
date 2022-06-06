<?php

namespace App\Models\Metric;

use App\Models\BaseModel;
use App\Models\Event;
use App\Models\Metric;

class EventMetricConfiguration extends BaseModel
{
    protected $table = 'event_metric_configurations';
    protected $guarded = [];

    public function metric()
    {
        return $this->belongsTo(Metric::class);
    }





}
