<?php

use Illuminate\Database\Seeder;

use App\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(City::class, 24)->create();
    }
}
