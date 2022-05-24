<?php

namespace App\Http\Controllers\Dashboard\Message;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MailCategoryRequest;
use App\Http\Requests\MailRequest;
use App\Services\MailCategoryService;
use App\Services\MailService;

class MailController extends CrudController
{

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MailService $service
     */
    public function __construct(MailService $service,MailRequest $request)
    {
        parent::__construct($service, $request);
    }

}
