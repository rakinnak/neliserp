<?php

namespace App\Http\Controllers\Api;

use App\Item;
use App\Http\Requests\ItemRequest;

class ItemApi extends ApiController
{
    public function index()
    {
        $items = Item::paginate();

        return $items;
    }

    public function show(Item $item)
    {
        return $item;
    }

    public function store(ItemRequest $request)
    {
        $created = Item::create([
            'uuid' => $request->uuid,
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return $created;
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->code = $request->code;
        $item->name = $request->name;

        $item->save();

        return $item;
    }

    public function destroy(Item $item)
    {
        $item->delete();
    }
}
