<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Http\Requests\Message\MailCategoryRoleRequest;
use App\Models\EventUser;
use App\Models\Message\Mail;
use App\Repositories\Eloquent\MailCategoryRepository;
use App\Repositories\Eloquent\MailCategoryRoleRepository;
use App\Repositories\Eloquent\MailRepository;
use App\Services\Shared\BaseService;

class MailCategoryRoleService extends BaseService
{
    protected string $modelName = "Mail_Categories_roles";
    protected $repository;
    public function __construct(MailCategoryRoleRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

}
