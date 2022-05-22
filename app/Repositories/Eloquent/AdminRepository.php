<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Repositories\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function create(array $payload): ?Model
    {
        $roles = [];
        if (isset($payload['roles'])){
            $roles = $payload['roles'];
            unset($payload['roles']);
        }

        $admin =  parent::create($payload);

        $admin->syncRoles($roles);

        return $admin;
    }

    public function update(int $modelId, array $payload)
    {
        $roles = [];
        if (isset($payload['roles'])){
            $roles = $payload['roles'];
            unset($payload['roles']);
        }

        $admin = parent::update($modelId, $payload);

        $admin->syncRoles($roles);

        return $admin;
    }
}
