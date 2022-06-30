<?php

namespace App\Repositories\Eloquent;

use App\Models\Level;
use App\Models\Metric\Leaderboard;
use App\Models\Metric\UserTotalPoints;

class LeaderboardRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Leaderboard $model
     */
    public function __construct(Leaderboard $model)
    {
        parent::__construct($model);
    }

    public function newTable (array $payload,$query){
        $payload['metrics_query_id'] = $query->id;
        unset($payload['metric_queries']);
        return $this->create($payload);
    }

}

