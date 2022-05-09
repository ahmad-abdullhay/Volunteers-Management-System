<?php

namespace App\Models\Metric;

use App\Models\BaseModel;

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

    protected $with = ['value'];
}
