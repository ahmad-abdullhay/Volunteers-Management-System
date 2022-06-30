<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Repositories\Eloquent\PointRuleRepository;
use App\Services\Shared\BaseService;

class PointRuleService extends BaseService
{
    protected string $modelName = "PointRule";
    protected MetricOperations $metricOperations;
    protected $repository;
    public function __construct(PointRuleRepository $repository)
    {
        $this->repository = $repository;
        $this->metricOperations = new MetricOperations();
        parent::__construct($repository);
    }
    public function getAll (){
        //return Badge::with('badgeCondition','badgeCondition.metricQuery')->get();

        return PointRule::with('metricQuery')->get();
    }
    public function newPointRule ($payload,MetricQueryService $metricQueryService){
        $query = $metricQueryService->newPointRuleMetricQuery($payload['metric_queries']);
      return  $this->repository->newPointRule($payload,$query);
    }

    public function  apply (Event $event,PointRule $pointRule,MetricQuery $metricQuery,MetricService $metricService){
        $userList =  EventUser::select('user_id',)
            ->where('event_id', $event->id)
            ->where('status', "1")->get();
        foreach ($userList as &$user){
            // get metrics list
            $valuesList = $metricService->getOneEventMetric($metricQuery->metric_id,$user->user_id,$event->id);
            if (empty($valuesList)){
                continue;
            }
      //      dd($valuesList[0]);
            $result =  $this->metricOperations->doOperation($metricQuery->first_operation,$valuesList[0]);

            $points = $result * $pointRule->points;
            if ($points > 0)
            $this->repository->addPointsToUserFromPointRule( $pointRule->id,$event->id,$user->user_id,$points,$pointRule->rule_name);


        }
    }
}


