<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Metric\MetricQuery;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\MetricQueryRepositoryInterface;

class MetricQueryRepository extends BaseRepository implements MetricQueryRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param MetricQuery $model
     */
    public function __construct(MetricQuery $model)
    {
        parent::__construct($model);
    }
}
