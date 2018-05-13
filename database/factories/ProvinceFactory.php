<?php

use Faker\Generator as Faker;

$factory->define(App\Province::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);
    $code = $faker->unique()->bothify(strtoupper(substr($name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'name' => $name,
        'country_id' => factory(App\Country::class)->create()->id,
        'country_uuid' => function($province) {
            return App\Country::find($province['country_id'])->uuid;
        }
    ];
});
