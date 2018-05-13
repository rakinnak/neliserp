<?php

use Illuminate\Database\Seeder;

use App\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(District::class, 24)->create();
    }
}
