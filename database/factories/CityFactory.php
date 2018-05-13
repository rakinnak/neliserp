<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);
    $code = $faker->unique()->bothify(strtoupper(substr($name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'name' => $name,
        'district_id' => factory(App\District::class)->create()->id,
        'district_uuid' => function($province) {
            return App\District::find($province['district_id'])->uuid;
        }
    ];
});
