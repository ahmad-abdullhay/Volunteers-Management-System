<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\PostRequest;
use App\Services\PostService;

class PostController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param PostService $service
     * @param PostRequest $request
     */
    public function __construct(PostService $postService, PostRequest $request)
    {
        parent::__construct($postService, $request);
    }

    public function readAll(){
        return $this->handleSharedMessage($this->service->readAll());
    }

    public function readOne($id){
        return $this->handleSharedMessage($this->service->readOne($id));
    }

    public function acceptPost($id){
        return $this->handleSharedMessage($this->service->acceptPost($id));
    }
}
