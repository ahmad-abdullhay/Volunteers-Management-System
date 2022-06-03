<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\EventMetricConfigurationRequest;
use App\Services\EventMetricConfigurationService;

class EventMetricConfigurationController extends CrudController
{
    protected EventMetricConfigurationService $configurationService;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param EventMetricConfigurationService $service
     * @param EventMetricConfigurationRequest $request
     */
    public function __construct(EventMetricConfigurationService $service, EventMetricConfigurationRequest $request)
    {
        $this->configurationService = $service;

        // Call on parent constructor.
        parent::__construct($service, $request);
    }

}
