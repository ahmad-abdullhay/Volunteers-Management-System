<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Models\Metric\UserTotalPoints;
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
    public function newPointRule (array $payload,$query){
        $payload['metrics_query_id'] = $query->id;
        unset($payload['metric_queries']);
        return $this->create($payload);
    }

    public function addPointsToUserFromPointRule ($pointRule_id,$event_id,$user_id,$points,$notes)
    {
        $userPoint = new UserPoint;
        $userPoint->event_id = $event_id;
        $userPoint->point_rule_id = $pointRule_id;
        $userPoint->points = $points;
        $userPoint->notes = $notes;
        $userPoint->operation = "add";
        $userPoint->user_id = $user_id;
        $userPoint->save();
        $totalPoints =  UserTotalPoints::where ('user_id',$user_id)->first();
        if ($totalPoints == null){
            $totalPoints = new UserTotalPoints;
            $totalPoints->total_points = $points;
            $totalPoints->user_id = $user_id;
            $totalPoints->save();
        } else {
        $totalPoints-> total_points+=$points;
        $totalPoints->update();
        }

    }
}
