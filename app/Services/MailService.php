<?php

namespace App\Services;

use App\Repositories\Eloquent\MailCategoryRepository;
use App\Repositories\Eloquent\MailRepository;
use App\Services\Shared\BaseService;

class MailService extends BaseService
{
    protected string $modelName = "Mail";
    protected $repository;
    public function __construct(MailRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


}
