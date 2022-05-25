<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\Event;
use App\Models\Metric\BadgeCondition;
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

    public function apply(Event $event, Badge $badge)
    {

        $userList = $event->with('users')->get()->first();
        // all conditions to get the badge
        $BadgeConditionList = BadgeCondition::where('badge_id', $badge->id)->get();


        foreach ($userList['users'] as &$user) {
            $isTrue = true;
            foreach ($BadgeConditionList as &$badgeCondition) {
                $query = MetricQuery::where('id', $badgeCondition->metric_query_id)->first();
                // if query for the last event only
                if ($query->second_operation == "null") {
                    $valuesList = [1, 1, 1];
                    $finalResult = $this->metricOperations->doOperation($query->first_operation, $valuesList);
                    // if query is for all events
                } else {
                    $valuesListList = [[6, 3, 1], [2, 2]];
                    // do first operation for inners arrays
                    $resultList = [];
                    foreach ($valuesListList as &$valueList) {
                        $result = $this->metricOperations->doOperation($query->first_operation, $valueList);
                        array_push($resultList, $result);
                    }
                    // do second operation for outer array (results array)
                    $finalResult = $this->metricOperations->doOperation($query->second_operation, $resultList);
                }
                // do compare
                $isTrue =
                    $this->metricOperations->doCompare($query->compare_operation, $finalResult, $badgeCondition->compare_value);
            }
            if ($isTrue) {
                $badgeUser = new BadgeUser;
                $badgeUser->badge_id = $badge->id;
                $badgeUser->note = 'hi';
                $badgeUser->user_id = $user->id;
                $badgeUser->save();
            }
        }
    }
}
