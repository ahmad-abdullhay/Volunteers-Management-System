<?php

namespace App\Services;

use App\Models\Metric\EventMetricConfiguration;
use App\Repositories\Eloquent\EventMetricConfigurationRepository;
use App\Repositories\Eloquent\MetricRepository;
use App\Services\Shared\BaseService;

class EventMetricConfigurationService extends BaseService
{
    protected string $modelName = "EventMetricConfiguration";
    protected $repository;

    public function __construct(EventMetricConfigurationRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function isValid (array $payload,MetricService $metricService){
       $pastValues = $metricService->getOneEventMetric($payload['metric_id'],$payload['user_id'],$payload['event_id']);
       $configuration = EventMetricConfiguration::where('metric_id', $payload['metric_id'])->where('event_id', $payload['event_id'])->first();
        if ($configuration == null)
            return true;
        if ($configuration->values_limit != null){
            if (count($pastValues) >= $configuration->values_limit)
                return "لقد ادخلت الحد الاقصى من هذا القياس";
        }
        if ($configuration->max_value != null){
            if ($payload['value'] > $configuration->max_value)
                return "القيمة المدخلة اكبر من الحد الاقصى";
        }
        if ($configuration->min_value != null){
            if ($payload['value'] < $configuration->min_value)
                return "القيمة المدخلة اصغر من الحد الادنى";
        }

        return true;
    }
}
