<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Metric\BadgeCondition;
use App\Services\BadgeConditionService;
use App\Services\EventService;
use App\Services\PointRuleService;
use Illuminate\Http\JsonResponse;

class EventController extends CrudController
{
    protected EventService $eventService;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param EventService $service
     * @param EventRequest $request
     */
    public function __construct(EventService $service, EventRequest $request)
    {
        $this->eventService = $service;

        // Call on parent constructor.
        parent::__construct($service, $request);
    }


    /**
     * @param Event $event
     * @param   PointRuleService $service
     * @param   BadgeConditionService $badgeService
     */
    public function eventEnd(Event $event, PointRuleService $service, BadgeConditionService $badgeService)
    {
        return
            $this->eventService->eventEnd($event,$service,$badgeService);

    }
}
