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
    public function newBadgeCondition ($badge_id,$metrics_query_id){
        $badgeCondition = new BadgeCondition;
        $badgeCondition->badge_id = $badge_id;
        $badgeCondition->metrics_query_id = $metrics_query_id;
        $badgeCondition->save();
        return $badgeCondition;
    }
}
