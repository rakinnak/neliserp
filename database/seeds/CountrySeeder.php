<?php

use Illuminate\Database\Seeder;

use App\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['code' => 'TH', 'name' => 'Thailand'],
        ];

        foreach ($countries as $country) {
            factory(Country::class)->create([
                'code' => $country['code'],
                'name' => $country['name'],
            ]);
        }
    }
}
