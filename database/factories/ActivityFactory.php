<?php

use Faker\Generator as Faker;

$factory->define(App\Activity::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'user_uuid' => function($activity) {
            return App\User::find($activity['user_id'])->uuid;
        },
        'user_username' => function($activity) {
            return App\User::find($activity['user_id'])->username;
        },
        'subject_id' => function() {
            return factory(App\Item::class)->create()->id;
        },
        'subject_type' => 'App\Item',
        'type' => 'items.created',
        'before' => null,
        'after' => null,
    ];
});
