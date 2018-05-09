<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'person_id' => function() {
            return factory(App\Person::class)->create()->id;
        },
        'person_uuid' => function($user) {
            return App\Person::find($user['person_id'])->uuid;
        },
    ];
});
