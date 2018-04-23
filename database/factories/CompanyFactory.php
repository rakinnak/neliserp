<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    $name = $faker->unique()->company();
    $code = 'C' . $faker->unique()->bothify(substr($name, 0, 1) . '-###');

    return [
        'uuid' => uuid(),
        'code' => $code,
        'name' => $name,
    ];
});
