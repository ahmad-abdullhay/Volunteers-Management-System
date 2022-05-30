<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Metric;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricEventValue;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Repositories\Eloquent\BadgeConditionRepository;
use App\Services\Shared\BaseService;

class BadgeConditionService extends BaseService
{
    protected string $modelName = "BadgeCondition";
    protected MetricOperations $metricOperations;
    protected $repository;

    public function __construct(BadgeConditionRepository $repository)
    {
        $this->repository = $repository;
        $this->metricOperations = new MetricOperations();
        parent::__construct($repository);
    }


    public function newBadgeCondition ($badge_id,$metrics_query_id){
       return $this->repository->newBadgeCondition($badge_id,$metrics_query_id);
    }


    public function apply(Event $event, Badge $badge,BadgeService $badgeService,MetricService $metricService)
    {

   //     $userList = $event->with('users')->get()->first();
        $userList =  EventUser::select('user_id',)
            ->where('event_id', $event->id)
            ->where('status', "1")->get();
        // all conditions to get the badge
        $BadgeConditionList = BadgeCondition::where('badge_id', $badge->id)->get();


        foreach ($userList as &$user) {
            if ($badgeService->isUserHasBadge($user->user_id,$badge->id))
                continue;

            $isTrue = false;
            foreach ($BadgeConditionList as &$badgeCondition) {
                $query = MetricQuery::where('id', $badgeCondition->metrics_query_id)->first();
                $finalResult =  $this->doOperations($badgeCondition,$query,$metricService,$user,$event);
                $isTrue =
                    $this->metricOperations->doCompare($query->compare_operation, $finalResult, $query->compare_value);
                }
                // do compare
            if ($isTrue) {
                $badgeService->automaticallyGiveBadgeToUser($user->user_id,$badge->id,$event->id,$event->name);
            }
            }

        }

    public function doOperations ($badgeCondition,$query,$metricService,$user,$event){
        // if query for the last event only
        if ($query->second_operation == "null") {
           return $this->oneEventOperation($metricService,$query,$user,$event);
            // if query is for all events
        } else {
            return  $this->allEventOperation($metricService,$query,$user);
        }
    }
    public function oneEventOperation (MetricService $metricService,$query,$user,$event){
        $valuesList = $metricService->getOneEventMetric($query->metric_id,$user->user_id,$event->id);
        if (empty($valuesList))
            return null;
        $finalResult = $this->metricOperations->doOperation($query->first_operation, $valuesList[0]);
        return $finalResult;
    }

    public function allEventOperation (MetricService $metricService,$query,$user){
        $valuesListList = $metricService->getAllEventMetric($query->metric_id,$user->user_id);
        if (empty($valuesListList))
            return null;
        // do first operation for inners arrays
        $resultList = [];
        foreach ($valuesListList as &$valueList) {
            $result = $this->metricOperations->doOperation($query->first_operation, $valueList);
            array_push($resultList, $result);
        }
        // do second operation for outer array (results array)
        $finalResult = $this->metricOperations->doOperation($query->second_operation, $resultList);
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $myJSON=json_encode($resultList);
        fwrite($myfile, $finalResult);
        fwrite($myfile, $myJSON);
        fclose($myfile);
        return $finalResult;
    }

}
