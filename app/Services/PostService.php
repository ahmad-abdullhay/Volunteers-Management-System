<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Post;
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
//        $post = $this->repository->
        return new SharedMessage(__('success.list', ['model' => 'Posts']),
            $this->repository->readOne($id),
            true,
            null,
            200
        );
    }

    public function acceptPost($id){
        $post = $this->repository->findById($id);
        //make post active (status = 1)
        $post->status = 1;
        $post->save();
        return new SharedMessage(__('success.list', ['model' => 'Posts']),
            [],
            true,
            null,
            201
        );
    }
}
