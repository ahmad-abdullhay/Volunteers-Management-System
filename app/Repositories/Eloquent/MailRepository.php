<?php

namespace App\Repositories\Eloquent;

use App\Models\Message\Mail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MailRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Mail $model
     */
    public function __construct(Mail $model)
    {
        parent::__construct($model);
    }

}
