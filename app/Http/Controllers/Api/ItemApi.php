<?php

namespace App\Http\Controllers\Api;

use App\Item;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemCollection;

class ItemApi extends ApiController
{
    public function index()
    {
        $items = Item::paginate();

        return ItemResource::collection($items);
    }

    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    public function store(ItemRequest $request)
    {
        $created = Item::create([
            'uuid' => uuid(),
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
