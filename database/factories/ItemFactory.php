<?php

use Faker\Generator as Faker;

$factory->define(App\Item::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);
    $code = $faker->unique()->bothify(substr($name, 0, 1) . '-###');

    return [
        'uuid' => uuid(),
        'code' => $code,
        'name' => $name,
    ];
});
