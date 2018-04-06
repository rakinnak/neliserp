<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'admin',
            'viewer',
        ];

        foreach ($users as $user) {
            factory(User::class)->create([
                'username' => $user,
                'name'     => $user,
                'email'    => "{$user}@example.com",
                'password' => bcrypt($user),
            ]);
        }
    }
}
