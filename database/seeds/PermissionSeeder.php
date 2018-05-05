<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'items.index',
            'items.show',
            'items.create',
            'items.update',
            'items.delete',

            'companies.index',
            'companies.show',
            'companies.create',
            'companies.update',
            'companies.delete',

            'persons.index',
            'persons.show',
            'persons.create',
            'persons.update',
            'persons.delete',

            'partners.index',
            'partners.show',
            'partners.create',
            'partners.update',
            'partners.delete',

            'docs.index',
            'docs.show',
            'docs.create',
            'docs.update',
            'docs.delete',

            'users.index',
            'users.show',
            'users.create',
            'users.update',
            'users.delete',

            'roles.index',
            'roles.show',
            'roles.create',
            'roles.update',
            'roles.delete',

            'permissions.index',
            'permissions.show',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
        ];

        foreach ($permissions as $permission) {
            factory(Permission::class)->create([
                'code' => $permission,
                'name' => $permission,
            ]);
        }
    }
}
