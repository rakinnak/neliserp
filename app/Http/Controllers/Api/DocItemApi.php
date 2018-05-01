<?php

namespace App\Http\Controllers\Api;

use App\Doc;
use App\DocItem;
use App\Item;

use App\Filters\DocItemFilter;
use App\Http\Requests\DocItemRequest;
use App\Http\Resources\DocItemResource;
use App\Http\Resources\DocItemCollection;

class DocItemApi extends ApiController
{
    public function index(DocItemFilter $filter, $type)
    {
        $this->authorize('index', DocItem::class);

        // TODO: search by type
        $doc_item = DocItem::filter($filter)
            ->paginate(10); // TODO: per page configuration

        return DocItemResource::collection($doc_item);
    }

    public function show($type, DocItem $doc_item)
    {
        $this->authorize('show', $doc_item);

        return new DocItemResource($doc_item);
    }

    public function store(DocItemRequest $request, $type, Doc $doc)
    {
        $this->authorize('create', DocItem::class);

        $item = Item::where('code', $request['item_code'])
            ->first();

        $created = DocItem::create([
            'doc_id' => $doc->id,
            'line_number' => $request['line_number'],
            'item_id' => $item->id,
            'ref_id' => null,
            'item_code' => $request['item_code'],
            'item_uuid' => $item->uuid,
            'item_name' => $item->name,
            'quantity' => $request['quantity'],
            'pending_quantity' => $request['quantity'],
            'unit_price' => $request['unit_price'],
        ]);

        return $created;
    }

    public function update(DocItemRequest $request, DocItem $doc_item)
    {
        $this->authorize('update', $doc_item);

        $item = Item::where('code', $request['item_code'])
            ->first();

        $doc_item->line_number = $request['line_number'];
        $doc_item->item_code = $request['item_code'];
        $doc_item->item_id = $item->id;
        $doc_item->item_uuid = $item->uuid;
        $doc_item->item_name = $item->name;
        $doc_item->quantity = $request['quantity'];
        $doc_item->pending_quantity = $request['quantity'];
        $doc_item->unit_price = $request['unit_price'];

        $doc_item->save();

        return $doc_item;
    }

    public function destroy(DocItem $doc_item)
    {
        $this->authorize('delete', $doc_item);

        $doc_item->delete();
    }
}
