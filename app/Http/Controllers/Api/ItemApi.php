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

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $items = Item::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

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

        $item->code = request('code');
        $item->name = request('name');

        $item->save();

        return $item;
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();
    }
}
