<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MetricQueryRequest;
use App\Services\MetricQueryService;

class MetricQueryController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MetricQueryService $service
     * @param MetricQueryRequest $request
     */
    public function __construct(MetricQueryService $service, MetricQueryRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }
}
