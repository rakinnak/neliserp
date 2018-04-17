<?php

namespace App\Http\Controllers\Api;

use App\Filters\ItemFilter;
use App\Item;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemCollection;

class ItemApi extends ApiController
{
    public function index(ItemFilter $filter)
    {
        $this->authorize('index', Item::class);

        $items = Item::filter($filter)
            ->paginate();

        return ItemResource::collection($items);
    }

    public function show(Item $item)
    {
        $this->authorize('show', $item);

        return new ItemResource($item);
    }

    public function store(ItemRequest $request)
    {
        $this->authorize('create', Item::class);

        $created = Item::create($request->toArray());

        return $created;
    }

    public function update(ItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);

        foreach ($request->toArray() as $field => $value) {
            $item->$field = $value;
        }

        $item->save();

        return $item;
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();
    }
}
