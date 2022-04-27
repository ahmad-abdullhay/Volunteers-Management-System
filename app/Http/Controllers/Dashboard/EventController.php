<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\EventRequest;
use App\Services\EventService;

class EventController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param EventService $service
     * @param EventRequest $request
     */
    public function __construct(EventService $service, EventRequest $request)
    {

        // Call on parent constructor.
        parent::__construct($service, $request);
    }
}
