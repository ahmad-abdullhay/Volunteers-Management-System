<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Event;
use App\Models\EventUser;
use App\Repositories\Eloquent\EventRepository;
use App\Services\Shared\BaseService;

class EventService extends BaseService
{
    protected string $modelName = "Event";
    protected $repository;
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function store($payload): SharedMessage
    {
        if (isset($payload['users'])){

            $users = $payload['users'];

            unset($payload['users']);


            $event =  $this->repository->create($payload);

            $this->repository->attachUsersToEvent(
                $event,
                $users,
                EventUser::SUPERVISOR,
                EventUser::ACCEPTED_STATUS
            );

            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $event,
                true,
                null,
                200
            );
        }


        return parent::store($payload);
    }

    /**
     * @param Event $event
     * @return SharedMessage
     */
    public function getEventUsers(Event $event)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUsers($event),
            true,
            null,
            200
        );
    }
}
