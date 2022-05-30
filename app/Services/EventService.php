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
    }

    public function getEventEndReport(Event $event)
    {
           $userId = Auth::id();
//        if ($event->status != 3){
//            $hasRate = EventUserRating::where('event_id', $event->id)->where('user_id', $userId)->get()->count();
//            return [
//                'no_report' => false,
//                'couldRate' => $hasRate < 1];
//        }

     //   $userId = 5;
        $userPoints = UserPoint::where('event_id', $event->id)->where('user_id', $userId)->get();
        $badgeUser = BadgeUser::where('event_id', $event->id)->where('user_id', $userId)->with('badge')->get();

        $status = 1;
        $endedEventCount = Event::where('status', 2)->with('users', function ($query) use ($status, $userId) {
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
                "info" => $rating],
            [
                "infoTitle" => "الدور",
                "info" => $isSupervisor]
        ];

        return [
            "event info" => $eventInfo,
            "points" => $userPoints,
            "badges" => $badgeUser];
    }

}
