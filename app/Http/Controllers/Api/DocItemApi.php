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
        $doc_items = DocItem::filter($filter)
            ->paginate(10); // TODO: per page configuration

        return DocItemResource::collection($doc_items);
    }

    public function show($type, DocItem $doc_item)
    {
        $this->authorize('show', $doc_item);

        $doc_item = $doc_item->load('doc');

        return new DocItemResource($doc_item);
    }

    public function store(DocItemRequest $request, $type, Doc $doc)
    {
        $this->authorize('create', DocItem::class);

        $item = Item::where('code', $request['item_code'])
            ->first();

        if ($request['ref_uuid'] == '') {
            $ref_id = null;
            $ref_uuid = null;
        } else {
            $ref_doc_item = DocItem::where('uuid', $request['ref_uuid'])
                ->first();
            $ref_id = $ref_doc_item->id;
            $ref_uuid = $ref_doc_item->uuid;

            $ref_doc_item->pending_quantity = $ref_doc_item->pending_quantity - $request['quantity'];
            $ref_doc_item->save();
        }

        $created = DocItem::create([
            'doc_id' => $doc->id,
            'doc_uuid' => $doc->uuid,
            'line_number' => $request['line_number'],
            'item_id' => $item->id,
            'ref_id' => $ref_id,
            'ref_uuid' => $ref_uuid,
            'item_code' => $request['item_code'],
            'item_uuid' => $item->uuid,
            'item_name' => $item->name,
            'quantity' => $request['quantity'],
            'pending_quantity' => $request['quantity'],
            'unit_price' => $request['unit_price'],
        ]);

        return $created;
    }

    public function update(DocItemRequest $request, $type, DocItem $doc_item)
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

    public function destroy($type, DocItem $doc_item)
    {
        $this->authorize('delete', $doc_item);

        $doc_item->delete();
    }
}
