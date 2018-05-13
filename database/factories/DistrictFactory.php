<?php

use Faker\Generator as Faker;

$factory->define(App\District::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);
    $code = $faker->unique()->bothify(strtoupper(substr($name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'name' => $name,
        'province_id' => factory(App\Province::class)->create()->id,
        'province_uuid' => function($province) {
            return App\Province::find($province['province_id'])->uuid;
        }
    ];
});
