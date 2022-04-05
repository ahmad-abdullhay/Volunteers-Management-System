<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Repositories\EventRepositoryInterface;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

}
