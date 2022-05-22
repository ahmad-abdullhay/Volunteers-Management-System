<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrCreate('Super Admin', 'admins');

        foreach ( config('permission.permissions') as $permission) {
            Permission::findOrCreate($permission, 'admins');
            $role->givePermissionTo($permission);
        }
    }
}

