<?php

namespace App\Http\Controllers\Dashboard\Badge;

use App\Http\Controllers\CrudController;
use App\Http\Requests\Badge\AddBadgeUserRequest;
use App\Http\Requests\Badge\BadgeRequest;
use App\Http\Requests\EventRequest;
use App\Services\BadgeService;
use App\Services\EventService;

class BadgeCRUDController extends CrudController
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

}
