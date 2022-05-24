<?php

namespace App\Repositories\Eloquent;

use App\Models\MailCategory;

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
