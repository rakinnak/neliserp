<?php

use Faker\Generator as Faker;

$factory->define(App\Doc::class, function (Faker $faker) {

    $company = factory(App\Partner::class)->create();

    $user = factory(App\User::class)->create();

    $issued_at = $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d');

    //$type = $faker->randomElement(['po', 'ro', 'ri', 'so', 'do', 'si']);
    $type = $faker->randomElement(['po', 'so']);

    $name = $faker->unique()->bothify(strtoupper($type) . '-####');

    return [
        'name' => $name,
        'type' => $type,
        'company_type' => 'App\Company',
        'company_id' => $company->id,
        'company_uuid' => $company->uuid,
        'company_code' => $company->code,
        'company_name' => $company->name,
        'user_id' => $user->id,
        'user_uuid' => $user->uuid,
        'user_username' => $user->username,
        'issued_at' => $issued_at,
    ];
});
