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
            ->where('type', $type)
            ->paginate(10); // TODO: per page configuration

        return DocResource::collection($docs);
    }

    public function show($type, Doc $doc)
    {
        $this->authorize('show', $doc);

        if ($doc->type != $type) {
            return response([], 404);
        }

        $doc = $doc->load('doc_item');

        return new DocResource($doc);
    }

    public function store(DocRequest $request, $type)
    {
        $this->authorize('create', Doc::class);

        $company = Company::where('code', $request['company_code'])
            ->first();

        $created = Doc::create([
            'name' => $request['name'],
            'type' => $type,
            'company_code' => $request['company_code'],
            'issued_at' => $request['issued_at'],
            'company_id' => $company->id,
            'company_uuid' => $company->uuid,
            'company_name' => $company->name,
        ]);

        return $created;
    }

    public function update(DocRequest $request, $type, Doc $doc)
    {
        $this->authorize('update', $doc);

        $company = Company::where('code', $request['company_code'])
            ->first();

        $doc->name = $request['name'];
        $doc->company_code = $request['company_code'];
        $doc->company_id = $company->id;
        $doc->company_uuid = $company->uuid;
        $doc->company_code = $company->code;
        $doc->company_name = $company->name;

        $doc->save();

        return $doc;
    }

    public function destroy($type, Doc $doc)
    {
        $this->authorize('delete', $doc);

        $doc->delete();
    }
}
