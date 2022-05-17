<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\EventUser;
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

    public function attachUsersToEvent($event, $users, $type, $status)
    {

        $usersData = [];

        foreach ($users as $key => $user){
            $usersData[$user] = [
                'status' => $status,
                'is_supervisor' => $type
            ];
        }

        $event->users()->attach($usersData);

        $event->save();
    }

    public function getEventUsers(Event $event)
    {R
        return Event::where('id', $event->id)->with('users', function ($query){
           $query->where('status', EventUser::ACCEPTED_STATUS);
        })->first();
    }
}
