<?php


namespace App\Services\Shared;


use App\Common\SharedMessage;
use App\Repositories\Eloquent\BaseRepository;

class BaseService
{

    protected $repository;

    protected string $modelName = "Resource";

    /**
     * BaseService constructor.
     *
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function store($payload): SharedMessage
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->create($payload),
            true,
            null,
            200
        );
    }

    /**
     * Update by id
     * @param $id
     * @param $payload
     * @return SharedMessage
     */
    public function update(int $id, array $payload): SharedMessage
    {
        return new SharedMessage(__('success.update', ['model' => $this->modelName]),
            $this->repository->update($id, $payload),
            true,
            null,
            200
        );
    }

    /**
     * Delete by id
     * @param int $id
     * @return SharedMessage
     */
    public function delete(int $id)
    {
        return new SharedMessage(__('success.delete', ['model' => $this->modelName]),
            $this->repository->deleteById($id),
            true,
            null,
            200
        );
    }

    /**
     * Get custom resource by id
     * @param int $id
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return mixed
     */
    public function view(
        int $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = [])
    {
        return new SharedMessage(__('success.get', ['model' => $this->modelName]),
            $this->repository->findById($id, $columns, $relations, $appends),
            true,
            null,
            200
        );
    }

    /**
     * Get all resources
     * @param array $columns
     * @param array $relations
     * @param int $length
     * @param array $sortKeys
     * @param array $sortDir
     * @param string|null $search
     * @return SharedMessage
     */
    public function index(
        array $columns = ['*'],
        array $relations = [],
        $length = 10,
        array $sortKeys = ['id'],
        array $sortDir = ['desc'],
        string $search = null
    )
    {
        return new SharedMessage(__('success.all', ['model' => $this->modelName]),
            $this->repository->all($columns, $relations, $length, $sortKeys, $sortDir, $search),
            true,
            null,
            200
        );
    }
}
