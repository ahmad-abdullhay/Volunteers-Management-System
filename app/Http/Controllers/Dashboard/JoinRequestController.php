<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\JoinRequestRequest;
use App\Services\JoinRequestService;

class JoinRequestController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param JoinRequestService $service
     * @param JoinRequestRequest $request
     */
    public function __construct(JoinRequestService $service, JoinRequestRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }
}
