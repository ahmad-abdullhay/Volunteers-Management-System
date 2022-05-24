<?php

namespace App\Services;

use App\Models\Event;
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
    public function  apply (Event $event,PointRule $pointRule,MetricQuery $metricQuery){

        $userList =   $event->with('users')->get()->first();

     //   return $userList['users'];
        foreach ($userList['users'] as &$user){
            // get metrics list
            $valuesList = [true,true,false];
            $result =  $this->metricOperations->doOperation($metricQuery->first_operation,$valuesList);
            $points = $result * $pointRule->points;
            //return $result;
            $userPoint = new UserPoint;
            $userPoint->points = $points;
            $userPoint->notes = $pointRule->rule_name;
            $userPoint->operation = "add";
            $userPoint->user_id = $user->id;
            $userPoint->save();

        }

      //  return $event;
    }
}


