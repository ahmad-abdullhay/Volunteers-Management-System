<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\CrudController;
use App\Http\Requests\AdminRequest;
use App\Services\Shared\BaseService;
use App\Services\AdminService;

class AdminCrudController extends CrudController
{
    protected BaseService $service;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param AdminService $service
     * @param AdminRequest $request
     *
     */
    public function __construct(AdminService $service, AdminRequest $request)
    {
        parent::__construct($service, $request);
    }
}
