<?php

namespace App\Http\Controllers\Dashboard\Event;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Event\RemoveUserRequest;
use App\Models\Event;
use App\Services\BadgeConditionService;
use App\Services\BadgeService;
use App\Services\EventService;
use App\Services\MetricService;
use App\Services\PointRuleService;
use Illuminate\Http\Request;

class EventController extends BaseController
{
    private EventService $service;

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param EventService $service
     */
    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function removeUserFromEvent(RemoveUserRequest $request)
    {
        return $this->handleSharedMessage($this->service->removeUserFromEvent($request->query()));
    }

    public function changeUserRoleStatus(RemoveUserRequest $request)
    {
        return $this->handleSharedMessage($this->service->changeUserRoleStatus($request->query()));
    }

    public function changeEventStatus (Event $event,Request $request,PointRuleService $service, BadgeConditionService $badgeConditionService,
                                       BadgeService $badgeService, MetricService $metricService)
    {
       // dd($request->post());
       return $this-> handleSharedMessage ( $this->service->changeEventStatus ($event,$request->query(),$service,  $badgeConditionService,
           $badgeService,  $metricService));
    }
}
