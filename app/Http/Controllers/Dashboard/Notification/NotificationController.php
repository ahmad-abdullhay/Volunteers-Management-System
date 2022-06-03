<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Notification\NotificationRequest;
use App\Services\Shared\BaseService;
use App\Services\NotificationService;

class NotificationController extends BaseController
{
    protected NotificationService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param NotificationService $service
     *
     */
    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }


}
