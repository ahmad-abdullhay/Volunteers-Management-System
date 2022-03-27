<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;

class RoleController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param RoleService $service
     * @param RoleRequest $request
     */
    public function __construct(RoleService $service, RoleRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function permissions()
    {
        return $this->handleSharedMessage($this->service->permissions());
    }
}
