<?php

namespace App\Http\Controllers\Api;

use App\Filters\CompanyFilter;
use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;

class CompanyApi extends ApiController
{
    public function index(CompanyFilter $filter)
    {
        $this->authorize('index', Company::class);
        
        $companies = Company::filter($filter)
            ->paginate(10); // TODO: per page configuration

        return CompanyResource::collection($companies);
    }

    public function show(Company $item)
    {
        $this->authorize('show', $item);

        return new CompanyResource($item);
    }

    public function store(CompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $created = Company::create($request->toArray());

        return $created;
    }

    public function update(CompanyRequest $request, Company $item)
    {
        $this->authorize('update', $item);

        // foreach ($request->toArray() as $field => $value) {
        //     $item->$field = $value;
        // }

        $item->code = request('code');
        $item->name = request('name');

        $item->save();

        return $item;
    }

    public function destroy(Company $item)
    {
        $this->authorize('delete', $item);

        $item->delete();
    }
}
