<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Repositories\Eloquent\BadgeRepository;
use App\Services\Shared\BaseService;

class BadgeService extends BaseService
{
    protected string $modelName = "Badge";
    protected $repository;
    public function __construct(BadgeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function addBadgeToUser(array $payload){
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->addBadgeToUser($payload),
            true,
            null,
            200
        );
    }

    public function indexWithIsErenAttribute(): SharedMessage
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository,
            true,
            null,
            200
        );
    }

}
