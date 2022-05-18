<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\Badge\AddBadgeUserRequest;
use App\Http\Requests\Badge\BadgeRequest;
use App\Http\Requests\EventRequest;
use App\Services\BadgeService;
use App\Services\EventService;

class BadgeController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param BadgeService $service
     * @param BadgeRequest $request
     */
    public function __construct(BadgeService $service, BadgeRequest $request)
    {

        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function addBadgeUser(AddBadgeUserRequest $payload ){
        return $this->handleSharedMessage($this->service->addBadgeToUser($payload));
    }
}
