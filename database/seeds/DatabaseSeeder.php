<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(RoleUserSeeder::class);

        $this->call(ItemSeeder::class);

        //$this->call(CompanySeeder::class);
        //$this->call(PersonSeeder::class);
        $this->call(PartnerSeeder::class);

        //$this->call(DocSeeder::class);
    }
}
