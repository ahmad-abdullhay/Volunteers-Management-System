<?php

namespace App\Models\Metric;

use App\Models\BaseModel;
use App\Models\Metric;

class MetricEventValue extends BaseModel
{
    protected $table = 'metric_event_value';

    protected $guarded = [];

    /**
     * Get the model that the image belongs to.
     */
    public function value()
    {
        return $this->morphTo(__FUNCTION__, 'valuable_type', 'metric_value_type_id');
    }

    public function metric()
    {
        return $this->belongsTo(Metric::class, 'metric_id');
    }

    protected $with = ['value'];
}
