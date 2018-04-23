<?php

use Illuminate\Database\Seeder;

use App\Doc;

class DocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Doc::class, 5)->create();
    }
}
