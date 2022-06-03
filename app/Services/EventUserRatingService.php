<?php

namespace App\Services;

use App\Repositories\Eloquent\EventUserRatingRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;

class EventUserRatingService extends BaseService
{
    protected string $modelName = "EventUserRating";
    protected $repository;

    public function __construct(EventUserRatingRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function rateEvent (array $payload){
        $payload['user_id'] = Auth::id();
     return   $this->repository->create($payload);
    }
}
