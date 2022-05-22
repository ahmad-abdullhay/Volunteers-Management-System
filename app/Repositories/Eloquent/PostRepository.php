<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);


    }

    public function readAll(){
        return Post::orderByDesc("created_at")->where("status",1)->with("admin")->get();
    }

    public function readOne($id){
        return Post::query()->where('id',$id)->where("status",1)->with("admin")->get();
    }



}
