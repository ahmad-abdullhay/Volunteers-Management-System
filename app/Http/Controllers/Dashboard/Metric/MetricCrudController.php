<?php

namespace App\Http\Controllers\Dashboard\Metric;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MetricRequest;
use App\Services\MetricService;

class MetricCrudController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MetricService $service
     * @param MetricRequest $request
     */
    public function __construct(MetricService $service, MetricRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

}
