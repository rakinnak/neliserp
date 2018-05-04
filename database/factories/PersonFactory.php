<?php

use Faker\Generator as Faker;

$factory->define(App\Person::class, function (Faker $faker) {
    $first_name = $faker->firstName();
    $last_name = $faker->lastName();
    $code = 'C' . $faker->unique()->bothify(substr($first_name, 0, 1) . '-###');

    return [
        'code' => $code,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ];
});
