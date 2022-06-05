<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MetricRequest;
use App\Models\Event;
use App\Services\MetricService;
use Illuminate\Http\Request;

class MetricController extends CrudController
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
    public function getEventMetrics(Event $event)
    {
        return $this->handleSharedMessage(
            $this->service->getEventMetricsWithConfiguration($event)
        );
    }

    public function getEventUserMetricValues(Request $request)
    {
        $params = $request->query();

        return $this->handleSharedMessage(
            $this->service->getEventUserMetricValues($params)
        );
    }

}
