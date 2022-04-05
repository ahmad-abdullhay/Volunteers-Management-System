<?php

namespace App\Services;

use App\Repositories\Eloquent\EventRepository;
use App\Services\Shared\BaseService;

class EventService extends BaseService
{
    protected string $modelName = "Event";

    public function __construct(EventRepository $repository)
    {
        parent::__construct($repository);
    }

}
