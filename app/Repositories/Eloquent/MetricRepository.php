<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric;
use App\Models\Metric\MetricEventValue;
use App\Repositories\MetricRepositoryInterface;


class MetricRepository extends BaseRepository implements MetricRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Metric $model
     */
    public function __construct(Metric $model)
    {
        parent::__construct($model);
    }

    public function insertMetricValue($payload)
    {
        $type = $payload['type'];

        $className = config('metric.'.$type);

        $model = resolve($className);
        $metricData = $model->create([
            'value' => $payload['value']
        ]);

        MetricEventValue::create([
            'user_id'               => $payload['user_id'],
            'event_id'              => $payload['event_id'],
            'metric_id'             => $payload['metric_id'],
            'metric_value_type_id'  => $metricData->id,
            'valuable_type'         => $className
        ]);
    }
}
