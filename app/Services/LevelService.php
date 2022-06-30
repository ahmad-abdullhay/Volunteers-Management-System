<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Level;
use App\Repositories\Eloquent\LevelRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Services\Shared\BaseService;

class LevelService extends BaseService
{
    protected string $modelName = "Level";

    public function __construct(LevelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getLevelUsers (Level $level)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getLevelUsers($level),
            true,
            null,
            200
        );
    }



}
