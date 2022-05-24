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
}
