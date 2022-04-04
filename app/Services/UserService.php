<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use App\Services\Shared\BaseService;

class UserService extends BaseService
{
    protected string $modelName = "User";

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

}
