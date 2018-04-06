<?php

use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'uuid' => uuid(),
        'code' => $faker->unique()->sentence(1),
        'name' => $faker->unique()->sentence(2),
    ];
});
