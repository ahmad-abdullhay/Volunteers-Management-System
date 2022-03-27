<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpaiteRole;

class RoleRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param SpaiteRole $model
     */
    public function __construct(SpaiteRole $model)
    {

    }

    public function all()
    {
        return SpaiteRole::with('permissions')->get();
    }

    public function create(array $payload): ?Model
    {
        //Assign Default Guard name To Payload.
        $payload['guard_name'] = 'admin';

        //Create Role.
        $role = SpaiteRole::create($payload);

        //Assign Permissions to the role.
        $role->syncPermissions($payload['permissions']);

        return $role;
    }

    public function deleteById(int $modelId): bool
    {
        return SpaiteRole::destroy($modelId);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return SpaiteRole::where('id', $modelId)->with('permissions')->first();
    }

    public function update(int $id, array $payload)
    {
        //Assign Default Guard name To Payload.
        $payload['guard_name'] = $payload['guard_name'] ?? 'admin';

        $role = SpaiteRole::where('id', $id)->first();

        $role->update($payload);

        $role->syncPermissions($payload['permissions']);

        return $role;
    }

    public function permissions()
    {
        return Permission::all();
    }
}
