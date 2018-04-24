<?php

use Faker\Generator as Faker;

$factory->define(App\Doc::class, function (Faker $faker) {
    $name = $faker->unique()->bothify('DOC-####');

    $company = factory(App\Company::class)->create();

    $issued_at = $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d');

    // $type: purchase_order, receive_order, receive_invoice, sales_order, delivery_order, sales_invoice
    // po, ro, ri, so, do, si

    return [
        'uuid' => uuid(),
        'name' => $name,
        'type' => 'docs',
        'company_id' => $company->id,
        'company_uuid' => $company->uuid,
        'company_code' => $company->code,
        'company_name' => $company->name,
        'issued_at' => $issued_at,
    ];
});
