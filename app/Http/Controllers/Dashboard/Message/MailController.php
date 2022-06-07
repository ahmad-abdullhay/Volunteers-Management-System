<?php

namespace App\Http\Controllers\Dashboard\Message;

use App\Http\Controllers\CrudController;
use App\Http\Requests\Message\MailRequest;
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

    public function getByAdminIdWithCategoryId($category_id){
        return $this->handleSharedMessage($this->service->getByAdminIdWithCategoryId($category_id));
    }

    public function AdminMessageUnread($category_id){
        return $this->service->AdminMessageUnread($category_id);
    }

    public function getByUserIdWithCategoryId($category_id){
        return $this->handleSharedMessage($this->service->getByUserIdWithCategoryId($category_id));
    }

    public function UserMessageUnread($category_id){
        return $this->service->UserMessageUnread($category_id);
    }
}
