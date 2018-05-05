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
        factory(Partner::class, 2)->states('customer', 'person')->create();
        factory(Partner::class, 25)->states('customer', 'company')->create();

        factory(Partner::class, 5)->states('supplier', 'person')->create();
        factory(Partner::class, 12)->states('supplier', 'company')->create();
    }
}
