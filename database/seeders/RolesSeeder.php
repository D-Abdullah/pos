<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = PERMISSIONS;

        $roles = [
            'super_admin' => ['*'],
            'admin' => ['create*', 'read*', 'update*'],
            'editor' => ['read*', 'update*'],
            'reporter' => ['read*']
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);

            foreach ($rolePermissions as $permissionPattern) {
                if (str_ends_with($permissionPattern, '*')) {
                    $basePermission = rtrim($permissionPattern, '*');
                    $matchingPermissions = preg_grep("/^{$basePermission}/", $permissions);
                    $role->givePermissionTo($matchingPermissions);
                } else {
                    $permissionName = $permissionPattern;
                    $permission = Permission::create(['name' => $permissionName]);
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
