<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\CrudController;
use App\Http\Requests\Notification\NotificationRequest;
use App\Services\Shared\BaseService;
use App\Services\NotificationService;

class NotificationCrudController extends CrudController
{
    protected BaseService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param NotificationService $service
     * @param NotificationRequest $request
     *
     */
    public function __construct(NotificationService $service, NotificationRequest $request)
    {
        parent::__construct($service, $request);
    }
}
