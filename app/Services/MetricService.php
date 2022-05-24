<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Metric\MetricEventValue;
use App\Repositories\Eloquent\MetricRepository;
use App\Services\Shared\BaseService;

class MetricService extends BaseService
{
    protected string $modelName = "Metric";
    protected $repository;
    public function __construct(MetricRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function insertMetricValue(array $payload)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->insertMetricValue($payload),
            true,
            null,
            200
        );
    }

    public function getEventMetrics($event)
    {


        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventMetrics($event),
            true,
            null,
            200
        );
    }

    public function getEventUserMetricValues($params)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUserMetricValues($params),
            true,
            null,
            200
        );
    }

    public function getMetricEvents()
    {
        $metricId = 1;
        $userId = 1;

        return MetricEventValue::where('user_id', $userId)->where('metric_id', $metricId)->get();
    }
}
