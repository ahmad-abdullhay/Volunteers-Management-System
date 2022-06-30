<?php

namespace App\Repositories\Eloquent;

use App\Models\Level;
use App\Models\Message\MailCategory;
use App\Models\Metric\UserTotalPoints;

class LevelRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Level $model
     */
    public function __construct(Level $model)
    {
        parent::__construct($model);
    }

    public function getLevelUsers (Level $level)
    {
        return UserTotalPoints::whereBetween('total_points', array($level->start_points, $level->min_points))->get();
    }

}


