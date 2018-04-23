<?php

use Faker\Generator as Faker;

$factory->define(App\Doc::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(1);
    $code = 'D' . $faker->unique()->bothify(substr($name, 0, 1) . '-###');

    return [
        'uuid' => uuid(),
        'code' => $code,
        'name' => $name,
    ];
});
