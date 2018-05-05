<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    $name = $faker->unique()->company();
    $code = $faker->unique()->bothify(strtoupper(substr($name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'name' => $name,
    ];
});
