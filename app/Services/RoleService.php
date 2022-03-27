<?php


namespace App\Services;

use App\Common\SharedMessage;
use App\Repositories\Eloquent\RoleRepository;
use App\Services\Shared\BaseService;

class RoleService extends BaseService
{
    protected string $modelName = "Role";

    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }

    public function permissions(): SharedMessage
    {
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            $this->repository->permissions(),
            true,
            null,
            200
        );
    }
}
