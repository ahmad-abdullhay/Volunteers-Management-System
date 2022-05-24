<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricQuery;
use App\Repositories\BadgeConditionRepositoryInterface;
use App\Repositories\MetricQueryRepositoryInterface;

class BadgeConditionRepository extends BaseRepository implements BadgeConditionRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param BadgeCondition $model
     */
    public function __construct(BadgeCondition $model)
    {
        parent::__construct($model);
    }
}
