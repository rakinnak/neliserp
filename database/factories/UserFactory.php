<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'uuid' => uuid(),
        'username' => $faker->userName,
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
    ];
});
