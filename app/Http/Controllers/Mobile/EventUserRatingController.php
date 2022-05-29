<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\EventUserRatingRequest;
use App\Http\Requests\PointRuleRequest;
use App\Services\EventService;
use App\Services\EventUserRatingService;
use App\Services\PointRuleService;

class EventUserRatingController extends BaseController
{
    protected EventUserRatingService $eventService;
    public function __construct(EventUserRatingService $eventService)
    {
        $this->eventService = $eventService;
    }
    public function rateEvent (EventUserRatingRequest $ratingRequest){
      return  $this->eventService->rateEvent ($ratingRequest->post());
    }
}
