<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'Viewer',
        ];

        foreach ($roles as $role) {
            factory(Role::class)->create([
                'code' => $role,
                'name' => $role,
            ]);
        }
    }
}
