<?php

namespace App\Models\Metric;

use App\Models\BaseModel;

class BadgeCondition extends BaseModel
{
    protected $table = 'badges_conditions';
    protected $guarded = [];

    public function metricQuery() {
        return $this->hasOne(MetricQuery::class,'id','metrics_query_id');
    }

}
