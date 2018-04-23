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
        ];

        foreach ($permissions as $permission) {
            factory(Permission::class)->create([
                'code' => $permission,
                'name' => $permission,
            ]);
        }
    }
}
