<?php

use Faker\Generator as Faker;

$factory->define(App\Partner::class, function (Faker $faker) {
    $company = factory(App\Company::class)->make();

    return [
        'subject_type' => 'App\Company',
        'subject_id' => $company->id,
        'subject_uuid' => $company->uuid,
        'code' => $company->code,
        'name' => $company->name,
        'is_customer' => false,
        'is_supplier' => false,
    ];
});
