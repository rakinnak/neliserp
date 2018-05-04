<?php

use Illuminate\Database\Seeder;

use App\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Partner::class, 12)->create();
    }
}
