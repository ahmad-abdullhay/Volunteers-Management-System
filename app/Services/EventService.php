<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Badge;
use App\Models\Event;
use App\Models\EventMetric;
use App\Models\EventUser;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Repositories\Eloquent\EventRepository;
use App\Services\Shared\BaseService;

class EventService extends BaseService
{
    protected string $modelName = "Event";
    protected $repository;
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function store($payload): SharedMessage
    {
        if (isset($payload['users'])){

            $users = $payload['users'];

            unset($payload['users']);


            $event =  $this->repository->create($payload);

            $this->repository->attachUsersToEvent(
                $event,
                $users,
                EventUser::SUPERVISOR,
                EventUser::ACCEPTED_STATUS
            );

            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $event,
                true,
                null,
                200
            );
        }


        return parent::store($payload);
    }

    /**
     * @param Event $event
     * @return SharedMessage
     */
    public function getEventUsers(Event $event , $status)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUsers($event, $status),
            true,
            null,
            200
        );
    }
    public function eventEnd (Event $event,PointRuleService $service,BadgeConditionService $badgeService){
        $metricsList = EventMetric::where('event_id', $event->id)->get();
        // this list to store processed badge (to not process it again)
        $badgeList = [];
        foreach ($metricsList as &$metric){
           // get all queries linked to this metric
            $queryList = MetricQuery::where('metric_id',$metric->metric_id)->get();
            foreach ($queryList as &$query) {
                // check if query is for point rule
                $pointRule =  PointRule::where('metric_query_id',$query->id)->first();
               if ($pointRule != null){
                 $service->apply ($event,$pointRule,$query);
                 continue;
               }

               // check if query is for badge condition
                $BadgeCondition =  BadgeCondition::where('metric_query_id',$query->id)->first();
                if ($BadgeCondition != null){
                    $badge = Badge::where('id',$BadgeCondition->badge_id)->first();
                    if ($badge != null && !in_array($badge->id, $badgeList)){
                        array_push($badgeList,$badge->id);
                         $badgeService->apply($event,$badge) ;
                    }
                }
            }
        }

    }
}
