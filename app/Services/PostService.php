<?php

namespace App\Services;

use App\Repositories\Eloquent\PostRepository;
use App\Services\Shared\BaseService;

class PostService extends BaseService
{
    protected string $modelName = "Post";
    protected $repository;
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
}
