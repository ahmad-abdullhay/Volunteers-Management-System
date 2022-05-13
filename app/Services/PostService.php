<?php

namespace App\Services;

use App\Common\SharedMessage;
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

    public function readAll()
    {
        return new SharedMessage(__('success.list', ['model' => 'Posts']),
            $this->repository->readAll(),
            true,
            null,
            200
        );
    }

    public function readOne($id){
        return new SharedMessage(__('success.list', ['model' => 'Posts']),
            $this->repository->findById($id,['*'],["admin"]),
            true,
            null,
            200
        );
    }
}
