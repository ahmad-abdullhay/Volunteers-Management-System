<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\UserRequest;
use App\Services\Shared\BaseService;
use App\Services\UserService;

class UserCrudController extends CrudController
{
    protected BaseService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param UserService $service
     * @param UserRequest $request
     *
     */
    public function __construct(UserService $service, UserRequest $request)
    {
        parent::__construct($service, $request);
    }
}
