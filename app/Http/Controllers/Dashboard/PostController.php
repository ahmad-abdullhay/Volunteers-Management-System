<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;


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

    public function readAll(Request $request){
        $params =  $request->query();
        return $this->handleSharedMessage($this->service->readAll($params));
    }

    public function readOne($id){
        return $this->handleSharedMessage($this->service->readOne($id));
    }

    public function acceptPost($id){
        return $this->handleSharedMessage($this->service->acceptPost($id));
    }
}
