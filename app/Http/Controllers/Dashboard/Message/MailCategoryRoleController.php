<?php

namespace App\Http\Controllers\Dashboard\Message;

use App\Http\Controllers\CrudController;
use App\Http\Requests\Message\MailCategoryRoleRequest;
use App\Http\Requests\Message\MailRequest;
use App\Services\MailCategoryRoleService;
use App\Services\MailService;

class MailCategoryRoleController extends CrudController
{

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MailCategoryRoleService $service
     */
    public function __construct(MailCategoryRoleService $service,MailCategoryRoleRequest $request)
    {
        parent::__construct($service, $request);
    }

}
