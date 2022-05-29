<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\EventUserRating;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\EventUserRatingRepositoryInterface;

class EventUserRatingRepository extends BaseRepository implements EventUserRatingRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param EventUserRating $model
     */
    public function __construct(EventUserRating $model)
    {
        parent::__construct($model);
    }
}
