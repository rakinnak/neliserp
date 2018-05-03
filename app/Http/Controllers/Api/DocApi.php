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

        $doc = $doc->load('doc_items');

        return new DocResource($doc);
    }

    public function store(DocRequest $request, $type)
    {
        $this->authorize('create', Doc::class);

        $user = auth()->user();

        $partner = Company::where('code', $request['partner_code'])
            ->first();

        $created = Doc::create([
            'name' => $request['name'],
            'type' => $type,
            'issued_at' => $request['issued_at'],
            'partner_type' => 'App\Company',
            'partner_id' => $partner->id,
            'partner_uuid' => $partner->uuid,
            'partner_code' => $partner->code,
            'partner_name' => $partner->name,
            'user_id' => $user->id,
            'user_uuid' => $user->uuid,
            'user_username' => $user->username,
        ]);

        return $created;
    }

    public function update(DocRequest $request, $type, Doc $doc)
    {
        $this->authorize('update', $doc);

        $partner = Company::where('code', $request['partner_code'])
            ->first();

        $doc->name = $request['name'];
        $doc->partner_code = $request['partner_code'];
        $doc->partner_type = 'App\Company';
        $doc->partner_id = $partner->id;
        $doc->partner_uuid = $partner->uuid;
        $doc->partner_code = $partner->code;
        $doc->partner_name = $partner->name;

        $doc->save();

        return $doc;
    }

    public function destroy($type, Doc $doc)
    {
        $this->authorize('delete', $doc);

        $doc->delete();
    }
}
