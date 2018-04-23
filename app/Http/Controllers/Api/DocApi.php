<?php

namespace App\Http\Controllers\Api;

use App\Filters\DocFilter;
use App\Doc;
use App\Http\Requests\DocRequest;
use App\Http\Resources\DocResource;
use App\Http\Resources\DocCollection;

class DocApi extends ApiController
{
    public function index(DocFilter $filter)
    {
        $this->authorize('index', Doc::class);
        
        $docs = Doc::filter($filter)
            ->paginate(10); // TODO: per page configuration

        return DocResource::collection($docs);
    }

    public function show(Doc $doc)
    {
        $this->authorize('show', $doc);

        return new DocResource($doc);
    }

    public function store(DocRequest $request)
    {
        $this->authorize('create', Doc::class);

        $created = Doc::create($request->toArray());

        return $created;
    }

    public function update(DocRequest $request, Doc $doc)
    {
        $this->authorize('update', $doc);

        // foreach ($request->toArray() as $field => $value) {
        //     $doc->$field = $value;
        // }

        $doc->code = request('code');
        $doc->name = request('name');

        $doc->save();

        return $doc;
    }

    public function destroy(Doc $doc)
    {
        $this->authorize('delete', $doc);

        $doc->delete();
    }
}
