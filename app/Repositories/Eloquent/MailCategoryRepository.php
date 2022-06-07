<?php

namespace App\Repositories\Eloquent;

use App\Models\Message\MailCategory;

class MailCategoryRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param MailCategory $model
     */
    public function __construct(MailCategory $model)
    {
        parent::__construct($model);
    }


}
