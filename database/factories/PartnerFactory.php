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
        'type' => $faker->randomElement(['customer', 'suppplier']),
    ];
});

$factory->state(App\Partner::class, 'company', function (Faker $faker) {
    return [
        'subject_type' => 'App\Company',
        'subject_id' => function() {
            return factory(App\Company::class)->create()->id;
        },
        'subject_uuid' => function ($subject) {
            return App\Company::find($subject['subject_id'])->uuid;
        },
        'code' => function ($subject) {
            return App\Company::find($subject['subject_id'])->code;
        },
        'name' => function ($subject) {
            $company = App\Company::find($subject['subject_id']);
            return "{$company->name}";
        },
    ];
});

$factory->state(App\Partner::class, 'person', function (Faker $faker) {
    return [
        'subject_type' => 'App\Person',
        'subject_id' => function() {
            return factory(App\Person::class)->create()->id;
        },
        'subject_uuid' => function ($subject) {
            return App\Person::find($subject['subject_id'])->uuid;
        },
        'code' => function ($subject) {
            return App\Person::find($subject['subject_id'])->code;
        },
        'name' => function ($subject) {
            $person = App\Person::find($subject['subject_id']);
            return "{$person->first_name} {$person->last_name}";
        },
    ];
});

$factory->state(App\Partner::class, 'customer', [
    'type' => 'customer',
]);

$factory->state(App\Partner::class, 'supplier', [
    'type' => 'supplier',
]);

