<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Metric\InsertMetricValuesRequest;
use App\Models\Event;
use App\Services\EventMetricConfigurationService;
use App\Services\MetricService;
use Illuminate\Http\Request;

class MetricController extends BaseController
{
    protected MetricService $metricService;
    public function __construct(MetricService $metricService)
    {
        $this->metricService = $metricService;
    }

    public function insertMetricForUser(InsertMetricValuesRequest $request,EventMetricConfigurationService $configurationService)
    {
        return $this->handleSharedMessage(
            $this->metricService->insertMetricValue($request->post(),$configurationService)
        );
    }

    public function getEventMetrics(Event $event)
    {
        return $this->handleSharedMessage(
          $this->metricService->getEventMetricsWithConfiguration($event)
        );
    }

    public function getEventUserMetricValues(Request $request)
    {
        $params = $request->query();

        return $this->handleSharedMessage(
            $this->metricService->getEventUserMetricValues($params)
        );
    }

    public function getEventUserInsertableMetrics(Request $request)
    {
        $params = $request->query();

        return $this->handleSharedMessage(
            $this->metricService->getEventUserInsertableMetrics($params)
        );
    }
}
