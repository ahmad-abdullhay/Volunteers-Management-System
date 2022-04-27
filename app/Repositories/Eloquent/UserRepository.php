<?php

namespace App\Repositories\Eloquent;

use App\Models\EventUser;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function activateVolunteer(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return $user->is_active;
    }

    public function changeVolunteersJoinEventStatus(array $payload)
    {
        $data = [];
        foreach($payload['users'] as $user){
            $data[] = [
                'user_id' => $user,
                'event_id' => $payload['event_id'],
                'status' => $payload['status']
            ];
        }

        return EventUser::insert($data);
    }

    public function joinEvent($payload)
    {
        return EventUser::create([
            'user_id' => auth()->id(),
            'event_id' => $payload['event_id']
        ]);
    }
}
