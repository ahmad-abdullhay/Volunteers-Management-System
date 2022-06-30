<?php

namespace App\Services;

use App\Repositories\Eloquent\MetricQueryRepository;
use App\Services\Shared\BaseService;

class MetricQueryService extends BaseService
{
    protected string $modelName = "MetricQuery";
    protected $repository;
    public function __construct(MetricQueryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function newPointRuleMetricQuery ($payload)
    {
        $payload['second_operation'] = 'null';
        $payload['compare_operation'] = 'null';
        $payload['compare_value'] = -1;
       return $this->repository->create($payload);
    }


    public function newBadgeMetricQuery ($payload)
    {
        return $this->repository->create($payload);
    }

    public function newLeaderboardMetricQuery ($payload)
    {
        $payload['compare_operation'] = 'null';
        $payload['compare_value'] = -1;
        return $this->repository->create($payload);
    }
}
