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

    public function getEventUsers(Event $event, $status)
    {
        return Event::where('id', $event->id)->with('users', function ($query) use ($status){
           $query->where('status', $status);
        })->first();
    }

    public function removeUserFromEvent($params)
    {
        $eventId = $params['event_id'];
        $event = $this->findById($eventId);

        $userId = $params['user_id'];
        $event->users()->detach($userId);

        return $userId;
    }

    public function changeUserRoleStatus($params)
    {
        $eventUserRelations = EventUser::where('user_id', $params['user_id'])->where('event_id', $params['event_id'])->first();
        $eventUserRelations->is_supervisor = !$eventUserRelations->is_supervisor;
        $eventUserRelations->save();

        return $params['user_id'];
    }

    public function changEventStatus(Event $event, $payload)
    {
        $event->status = $payload['status'];
        $event->save();
    }
}
