<?php

use Faker\Generator as Faker;

$factory->define(App\DocItem::class, function (Faker $faker) {
    $doc = factory(App\Doc::class)->create();
    $item = factory(App\Item::class)->create();
    $line_number = $faker->numberBetween(1, 5);
    $quantity = $faker->numberBetween(1, 20);
    $unit_price = $faker->randomFloat(2, $min = 0.01, $max = 100);

    return [
        'doc_id' => $doc->id,
        'item_id' => $item->id,
        'ref_id' => null,
        'doc_uuid' => $doc->uuid,
        'item_uuid' => $item->uuid,
        'ref_uuid' => null,
        'line_number' => $line_number,
        'item_code' => $item->code,
        'item_name' => $item->name,
        'quantity' => $quantity,
        'pending_quantity' => $quantity,
        'unit_price' => $unit_price,
    ];
});
