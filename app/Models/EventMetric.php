<?php

namespace App\Models;

use App\Models\Metric\EventMetricConfiguration;

class EventMetric extends BaseModel
{
    protected $table = 'event_metric';

    public $timestamps = false;
    public function metric()
    {
        return $this->belongsTo(Metric::class);
    }
}
