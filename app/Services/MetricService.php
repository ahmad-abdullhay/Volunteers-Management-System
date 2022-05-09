<?php

namespace App\Services;

use App\Common\SharedMessage;
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

}
