<?php

namespace App\Repositories\Eloquent;

use App\Models\Message\Mail;
use App\Models\Message\MailCategoriesRoles;
use App\Models\Message\MailCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MailCategoryRoleRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param MailCategoriesRoles $model
     */
    public function __construct(Mail $model)
    {
        parent::__construct($model);
    }


}
