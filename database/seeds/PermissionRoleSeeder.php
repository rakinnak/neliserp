<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        $roles['Admin'] = explode(',', $permissions->implode('name', ','));

        $roles['Viewer'] = [];

        foreach ($roles as $role => $permissions) {
            foreach ($permissions as $permission) {
                Role::where('name', $role)
                    ->first()
                    ->givePermissionTo(Permission::where('name', $permission)->first());
            }
        }
    }
}
