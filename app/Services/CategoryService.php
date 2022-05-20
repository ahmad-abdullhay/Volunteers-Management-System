<?php

namespace App\Services;

use App\Repositories\Eloquent\CategoryRepository;
use App\Services\Shared\BaseService;

class CategoryService extends BaseService
{
    protected string $modelName = "Category";
    protected $repository;
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
}
