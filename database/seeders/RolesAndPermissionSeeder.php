<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super admin will have all the access
        $superAdminRole = Role::where('name', 'super-admin')->first();

        if ($superAdminRole) {
            $permissions = Permission::get();

            if ($permissions) {
                $superAdminRole->syncPermissions($permissions);
            }
        }

        // Admin has access to "action" permission
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $actionPermission = Permission::where('name', 'action')->first();

            if ($actionPermission) {
                $adminRole->givePermissionTo($actionPermission);
            }
        }
    }
}
