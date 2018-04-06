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
            'items.view',
            'items.create',
            'items.update',
            'items.delete',
        ];

        foreach ($permissions as $permission) {
            factory(Permission::class)->create([
                'code' => $permission,
                'name' => $permission,
            ]);
        }
    }
}
