<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\Event;
use App\Models\Metric\PointRule;
use App\Repositories\Eloquent\BadgeRepository;
use App\Services\Shared\BaseService;

class BadgeService extends BaseService
{
    protected string $modelName = "Badge";
    protected $repository;

    public function __construct(BadgeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function getAll (){
        return Badge::with('badgeCondition','badgeCondition.metricQuery')->get();

    }
    public function createBadge ($payload,MetricQueryService $metricQueryService,BadgeConditionService $badgeConditionService){
        $x = $payload['metric_queries'];
        $badgePayload = $payload->all();
        unset($badgePayload['metric_queries']);
       $badge =  $this->repository->create($badgePayload);
        foreach ($x as &$metric_query){
            $query = $metricQueryService->newBadgeMetricQuery($metric_query);
            $badgeConditionService->newBadgeCondition($badge->id,$query->id);
        }
    }
    public function addBadgeToUser(array $payload)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->addBadgeToUser($payload),
            true,
            null,
            200
        );
    }

    public function isUserHasBadge($user_id,$badge_id)
    {
     $badge =   $this->repository->getUserBadge($user_id,$badge_id);
     return $badge != null;

    }
    public function automaticallyGiveBadgeToUser($user_id, $badge_id,$event_id, $note)
    {
        $this->repository->automaticallyGiveBadgeToUser($user_id,$badge_id,$event_id,$note);

    }

    public function indexWithIsErenAttribute(): SharedMessage
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository,
            true,
            null,
            200
        );
    }

    public function usersHaveBadge(Badge $badge)
    {
        return Badge::where('id', $badge->id)->with('users')->get();
    }

}
