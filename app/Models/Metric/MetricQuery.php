<?php

namespace App\Models\Metric;

use App\Models\BaseModel;
use App\Models\Metric;

class MetricQuery extends BaseModel
{
    protected $table = 'metric_queries';
    protected $guarded = [];
   // protected $with = [ 'metrics'];
//    public function metrics()
//    {
//        return $this->belongsToMany(Metric::class);
//    }

}
