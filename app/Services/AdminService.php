<?php

namespace App\Services;

use App\Repositories\Eloquent\AdminRepository;
use App\Services\Shared\BaseService;

class AdminService extends BaseService
{
    protected string $modelName = "Admin";
    protected $repository;
    public function __construct(AdminRepository $repository)
    {

        $this->repository = $repository;
        parent::__construct($repository);
    }
}
