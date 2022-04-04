<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Repositories\Eloquent\JoinRequestRepository;
use App\Services\Shared\BaseService;

class JoinRequestService extends BaseService
{
    protected string $modelName = "JoinRequest";
    protected UserService $userService;
    public function __construct(JoinRequestRepository $repository, UserService $userService)
    {
        parent::__construct($repository);
        $this->userService = $userService;
    }

    public function store($payload): SharedMessage
    {
        $user = $this->userService->store($payload)->data;

        //Prepare Join Request Data.
        $joinRequestPayload = [];
        $joinRequestPayload['admin_id'] = auth()->id();
        $joinRequestPayload['user_id'] = $user->id;

        return parent::store($joinRequestPayload);
    }

    public function index(array $columns = ['*'], array $relations = [], $length = 10, array $sortKeys = ['id'], array $sortDir = ['desc'], string $search = null)
    {
        return parent::index($columns, ['admin', 'user'], $length, $sortKeys, $sortDir, $search);
    }

    public function view(int $id, array $columns = ['*'], array $relations = [], array $appends = [])
    {
        return parent::view($id, $columns, ['admin', 'user'], $appends);
    }

    public function delete(int $id)
    {
        $user = $this->view($id)->data->user;

        parent::delete($id)->data;

        if (!$user->is_active)
            $this->userService->delete($user->id);

        return new SharedMessage(__('success.delete', ['model' => $this->modelName]),
            true,
            true,
            null,
            200
        );
    }
}
