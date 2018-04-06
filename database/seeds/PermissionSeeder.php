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
            'items.create',
            'items.store',
            'items.show',
            'items.edit',
            'items.update',
            'items.delete',
            'items.destroy',
        ];

        foreach ($permissions as $permission) {
            factory(Permission::class)->create([
                'code' => $permission,
                'name' => $permission,
            ]);
        }
    }
}
