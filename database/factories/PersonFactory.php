<?php

use Faker\Generator as Faker;

$factory->define(App\Person::class, function (Faker $faker) {
    $first_name = $faker->firstName();
    $last_name = $faker->lastName();
    $code = $faker->unique()->bothify(strtoupper(substr($first_name, 0, 2)) . '-###');

    return [
        'code' => $code,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ];
});
