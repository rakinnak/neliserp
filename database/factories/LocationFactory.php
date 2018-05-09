<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);
    $code = $faker->unique()->bothify(strtoupper(substr($name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'lft' => $faker->unique()->randomNumber(),
        'rgt' => $faker->unique()->randomNumber(),
        'name' => $name,
    ];
});
