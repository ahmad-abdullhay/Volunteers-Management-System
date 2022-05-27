<?php

namespace App\Services;

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
}
