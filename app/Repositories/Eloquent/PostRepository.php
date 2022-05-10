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


}
