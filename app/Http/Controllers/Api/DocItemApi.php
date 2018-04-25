<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\DocItem;

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

    public function store(DocItemRequest $request, $type)
    {
        $this->authorize('create', DocItem::class);

        $company = Company::where('uuid', $request['company_uuid'])
            ->first();

        $created = DocItem::create([
            'name' => $request['name'],
            'type' => $type,
            'company_uuid' => $request['company_uuid'],
            'company_id' => $company->id,
            'company_code' => $company->code,
            'company_name' => $company->name,
            'issued_at' => $request['issued_at'],
        ]);

        return $created;
    }

    public function update(DocItemRequest $request, $type, DocItem $doc_item)
    {
        $this->authorize('update', $doc_item);

        $company = Company::where('uuid', $request['company_uuid'])
            ->first();

        $doc_item->name = $request['name'];
        $doc_item->company_uuid = $request['company_uuid'];
        $doc_item->company_id = $company->id;
        $doc_item->company_code = $company->code;
        $doc_item->company_name = $company->name;

        $doc_item->save();

        return $doc_item;
    }

    public function destroy($type, DocItem $doc_item)
    {
        $this->authorize('delete', $doc_item);

        $doc_item->delete();
    }
}
