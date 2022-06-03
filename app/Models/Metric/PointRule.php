<?php

namespace App\Models\Metric;

use App\Models\BaseModel;

class PointRule extends BaseModel
{
    protected $table = 'point_rules';
    protected $guarded = [];

    public function metricQuery() {
        return $this->hasOne(MetricQuery::class,'id','metrics_query_id');
    }


}
