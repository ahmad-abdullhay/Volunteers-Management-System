<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\Metric\EventMetricConfiguration;
use App\Repositories\EventMetricConfigurationRepositoryInterface;
use App\Repositories\EventRepositoryInterface;

class EventMetricConfigurationRepository extends BaseRepository implements EventMetricConfigurationRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param EventMetricConfiguration $model
     */
    public function __construct(EventMetricConfiguration $model)
    {
        parent::__construct($model);
    }
}
