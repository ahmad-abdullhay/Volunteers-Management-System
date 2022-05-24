<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Repositories\PointRuleRepositoryInterface;

class PointRuleRepository extends BaseRepository implements PointRuleRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param PointRule $model
     */
    public function __construct(PointRule $model)
    {
        parent::__construct($model);
    }
}
