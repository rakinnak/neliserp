<?php

use Illuminate\Database\Seeder;

use App\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Province::class, 24)->create();
    }
}
