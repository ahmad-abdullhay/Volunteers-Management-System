<?php

namespace App\Http\Controllers\Dashboard\Message;

use  App\Http\Controllers\CrudController;
use App\Http\Requests\Message\MailCategoryRequest;
use App\Services\MailCategoryService;

class MailCategoryController extends CrudController
{

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MailCategoryService $service
     */
    public function __construct(MailCategoryService $service,MailCategoryRequest $request)
    {
        parent::__construct($service, $request);
    }

}
