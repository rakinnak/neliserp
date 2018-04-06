<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles['Admin'] = [
            'admin',
        ];

        $roles['Viewer'] = [
            'viewer',
        ];

        foreach ($roles as $role => $users) {
            foreach ($users as $user) {
                Role::where('name', $role)
                    ->first()
                    ->users()
                    ->save(User::where('name', $user)->first());
            }
        }
    }
}
