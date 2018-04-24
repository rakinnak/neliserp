<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Doc;

use App\Filters\DocFilter;
use App\Http\Requests\DocRequest;
use App\Http\Resources\DocResource;
use App\Http\Resources\DocCollection;

class DocApi extends ApiController
{
    public function index(DocFilter $filter, $type)
    {
        $this->authorize('index', Doc::class);
        
        $docs = Doc::filter($filter)
            ->paginate(10); // TODO: per page configuration

        return DocResource::collection($docs);
    }

    public function show($type, Doc $doc)
    {
        $this->authorize('show', $doc);

        return new DocResource($doc);
    }

    public function store(DocRequest $request, $type)
    {
        $this->authorize('create', Doc::class);

        $company = Company::find($request['company_id']);

        $created = Doc::create([
            'name' => $request['name'],
            'type' => $type,
            'company_id' => $request['company_id'],
            'company_uuid' => $company->uuid,
            'company_code' => $company->code,
            'company_name' => $company->name,
            'issued_at' => $request['issued_at'],
        ]);

        return $created;
    }

    public function update(DocRequest $request, $type, Doc $doc)
    {
        $this->authorize('update', $doc);

        // foreach ($request->toArray() as $field => $value) {
        //     $doc->$field = $value;
        // }

        $doc->name = request('name');

        $doc->save();

        return $doc;
    }

    public function destroy($type, Doc $doc)
    {
        $this->authorize('delete', $doc);

        $doc->delete();
    }
}
