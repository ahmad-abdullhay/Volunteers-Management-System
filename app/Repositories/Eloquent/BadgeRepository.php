<?php

namespace App\Repositories\Eloquent;

use App\Models\Badge;
use App\Models\VolunteersBadge;

class BadgeRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Badge $model
     */
    public function __construct(Badge $model)
    {
        parent::__construct($model);
    }

    public function addBadgeToUser(array $payload){
        return VolunteersBadge::create($payload);
    }
}
