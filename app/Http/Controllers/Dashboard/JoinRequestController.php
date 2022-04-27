<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\JoinRequestRequest;
use App\Models\JoinRequest;
use App\Services\JoinRequestService;
use App\Services\Shared\BaseService;

class JoinRequestController extends CrudController
{
    protected BaseService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param JoinRequestService $service
     * @param JoinRequestRequest $request
     */
    public function __construct(JoinRequestService $service, JoinRequestRequest $request)
    {
        $this->service = $service;
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function changeRequestStatus($modelId)
    {
        return $this->handleSharedMessage(
            $this->service->changeRequestStatus($modelId, JoinRequest::STATUS_WAITING_FOR_HR_OFFICER)
        );
    }
}
