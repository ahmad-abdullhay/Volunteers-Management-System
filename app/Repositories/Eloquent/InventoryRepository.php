<?php

namespace App\Repositories\Eloquent;

use App\Models\Inventory;
use App\Models\Metric\MetricQuery;

class InventoryRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Inventory $model
     */
    public function __construct(Inventory $model)
    {
        parent::__construct($model);
    }
    public function getAll ()
    {
        return  $this->model::get();
    }
}
