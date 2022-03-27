<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->columns = ['name', 'email'];
        parent::__construct($model);
    }
}
