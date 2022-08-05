<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\Event;
use App\Models\EventMetric;
use App\Models\EventUser;
use App\Models\EventUserRating;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\EventPointStats;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Repositories\Eloquent\EventRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;

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
        if (isset($payload['users'])) {

            $users = $payload['users'];

            unset($payload['users']);


            $event = $this->repository->create($payload);

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

    public function update(int $id, array $payload): SharedMessage
    {
        if (isset($payload['users'])) {

            $users = $payload['users'];

            unset($payload['users']);
        }
        $event = $this->repository->update($id, $payload);
        $event->supervisors()->detach();
        $this->repository->attachUsersToEvent(
            $event,
            $users,
            EventUser::SUPERVISOR,
            EventUser::ACCEPTED_STATUS
        );
        return new SharedMessage(__('success.update', ['model' => $this->modelName]),
            $event,
            true,
            null,
            200
        );
    }

    /**
     * @param Event $event
     * @return SharedMessage
     */
    public function getEventUsers(Event $event, $status)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUsers($event, $status),
            true,
            null,
            200
        );
    }

    public function eventEnd(Event        $event, PointRuleService $service, BadgeConditionService $badgeConditionService,
                             BadgeService $badgeService, MetricService $metricService)
    {
        $metricService->onEventEnding($event, $service, $badgeConditionService, $badgeService);
        $metricService->eventPointsStatCalculate($event);
    }

    public function getEventEndReport(Event $event)
    {
           $userId = Auth::id();
        if ($event->status == 2){
            $hasRate = EventUserRating::where('event_id', $event->id)->where('user_id', $userId)->get()->count();
            return [
                'no_report' => false,
                'couldRate' => $hasRate < 1];
        }

        $userPoints = UserPoint::where('event_id', $event->id)->where('user_id', $userId)->where('points' ,'>',0)->get();
        $badgeUser = BadgeUser::where('event_id', $event->id)->where('user_id', $userId)->with('badge')->get();
        $pointStats = EventPointStats::where ('event_id', $event->id)->where('user_id', $userId)->first();
        $status = 1;
        $endedEventCount = Event::where('status', 3)->with('users', function ($query) use ($status, $userId) {
            $query->where('status', $status)->where("user_id", $userId);
        })->get()->count();
        $rating = EventUserRating:: where('event_id', $event->id)->avg("rating");
        $isSupervisor = EventUser::where('event_id', $event->id)->where('user_id', $userId)->get()->first()->is_supervisor;
        $isSupervisor == 0 ? $isSupervisor = 'متطوع' :$isSupervisor = 'مشرف' ;
        $eventInfo = [
            [
            "infoTitle" => "عدد الفعاليات المنتهية",
            "info" => $endedEventCount],
            [
                "infoTitle" => "التقييم",
                "info" =>round($rating, 2) ],
            [
                "infoTitle" => "الدور",
                "info" => $isSupervisor]
        ];


        return [
            "event info" => $eventInfo,
            "points" => $userPoints,
            "badges" => $badgeUser,
            "pointStats"=>$pointStats];
    }
    public function view(int $id, array $columns = ['*'], array $relations = [], array $appends = [])
    {
        $data = parent::view($id, $columns, ['metrics'], $appends)->data;

        $users = collect($data['users']);

        //Getting Accepted users.
        $data['acceptedUsers'] = array_values($users
            ->where('pivot.status', EventUser::ACCEPTED_STATUS)
            ->where('pivot.is_supervisor', EventUser::NOT_SUPERVISOR)->toArray());


        //Getting Event Supervisors.
        $data['supervisors'] = array_values($users
            ->where('pivot.is_supervisor', EventUser::SUPERVISOR)->toArray());

        //Getting Pending Join requests.
        $data['pendingUsers'] = array_values($users
            ->where('pivot.status', EventUser::PENDING_STATUS)->toArray());

        //Getting Pending Join requests.
        $data['rejectedUsers'] = array_values($users
            ->where('pivot.status', EventUser::REJECTED_STATUS)->toArray());

        unset($data['users']);

        return new SharedMessage(__('success.get', ['model' => $this->modelName]),
            $data,
        true,
        null,
        200
        );

    }

    public function removeUserFromEvent($params)
    {
        return new SharedMessage(__('event.user-removed'),
            $this->repository->removeUserFromEvent($params),
            true,
            null,
            200
        );
    }

    public function changeUserRoleStatus($params)
    {
        return new SharedMessage(__('event.status-changed'),
            $this->repository->changeUserRoleStatus($params),
            true,
            null,
            200
        );
    }

    public function changeEventStatus(Event $event,$payload,PointRuleService $service, BadgeConditionService $badgeConditionService,
                                      BadgeService $badgeService, MetricService $metricService)
    {
        if ($payload['status'] == 3){
            $this->eventEnd( $event,$service,  $badgeConditionService,
                              $badgeService,  $metricService);
        }
        $this->repository->changEventStatus ( $event,$payload);
        return new SharedMessage(__('event.status-changed'),
         true,
            true,
            null,
            200
        );

    }
    public function tempChangeEventStatus(Event $event,$payload,PointRuleService $service, BadgeConditionService $badgeConditionService,
                                      BadgeService $badgeService, MetricService $metricService)
    {
        $payload['status'] = 3;
        if ($payload['status'] == 3){
            $this->eventEnd( $event,$service,  $badgeConditionService,
                $badgeService,  $metricService);
        }
        $this->repository->changEventStatus ( $event,$payload);
        return new SharedMessage(__('event.status-changed'),
            true,
            true,
            null,
            200
        );

    }
}
