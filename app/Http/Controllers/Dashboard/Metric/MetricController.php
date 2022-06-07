<?php

namespace App\Http\Controllers\Dashboard\Metric;

use App\Http\Controllers\BaseController;
use App\Services\MetricService;
use Illuminate\Http\Request;

class MetricController extends BaseController
{
    private MetricService $service;

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MetricService $service
     */
    public function __construct(MetricService $service)
    {
        $this->service = $service;
    }

    public function getEventUserMetricValues(Request $request)
    {
        $params = $request->query();

        return $this->handleSharedMessage(
            $this->service->getUserMetricValues($params)
        );
    }
}
