<?php

use Faker\Generator as Faker;

$factory->define(App\Doc::class, function (Faker $faker) {

    $partner = factory(App\Partner::class)->states('customer', 'company')->create();

    $user = factory(App\User::class)->create();

    $issued_at = $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d');

    //$type = $faker->randomElement(['po', 'ro', 'ri', 'so', 'do', 'si']);
    //$type = $faker->randomElement(['po', 'so']);
    $type = $faker->randomElement(['so']);

    $name = $faker->unique()->bothify(strtoupper($type) . '-####');

    return [
        'name' => $name,
        'type' => $type,
        'partner_id' => $partner->id,
        'partner_uuid' => $partner->uuid,
        'partner_code' => $partner->code,
        'partner_name' => $partner->name,
        'user_id' => $user->id,
        'user_uuid' => $user->uuid,
        'user_username' => $user->username,
        'issued_at' => $issued_at,
    ];
});
