<?php

namespace App\Models\Metric;

use App\Models\BaseModel;

class Leaderboard extends BaseModel
{
    protected $table = 'leaderboards';
    protected $guarded = [];
    protected $with = ['metricQuery'];
    public function metricQuery() {
        return $this->hasOne(MetricQuery::class,'id','metrics_query_id');
    }

}


