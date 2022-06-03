<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\Shared\BaseService;
use App\Services\UserService;

class UserController extends BaseController
{
    protected BaseService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param UserService $service
     *
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function activateVolunteer(User $user)
    {
        return $this->handleSharedMessage($this->service->activateVolunteer($user));
    }

    public function searchByName($key){
        return $this->handleSharedMessage($this->service->searchByName($key));
    }

}
