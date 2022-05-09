<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Metric\InsertMetricValuesRequest;
use App\Models\Metric\MetricEventValue;
use App\Services\MetricService;

class MetricController extends BaseController
{
    protected MetricService $metricService;
    public function __construct(MetricService $metricService)
    {
        $this->metricService = $metricService;
    }

    public function insertMetricForUser(InsertMetricValuesRequest $request)
    {
        return $this->handleSharedMessage(
            $this->metricService->insertMetricValue($request->post())
        );
    }
}
