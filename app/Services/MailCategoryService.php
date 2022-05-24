<?php

namespace App\Services;

use App\Repositories\Eloquent\MailCategoryRepository;
use App\Services\Shared\BaseService;

class MailCategoryService extends BaseService
{
    protected string $modelName = "MailCategory";
    protected $repository;
    public function __construct(MailCategoryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }



}
