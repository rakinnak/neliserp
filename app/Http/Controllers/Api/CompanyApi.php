<?php

namespace App\Http\Controllers\Api;

use App\Filters\CompanyFilter;
use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;

class CompanyApi extends ApiController
{
    public function index(CompanyFilter $filter)
    {
        $this->authorize('index', Company::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $companies = Company::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return CompanyResource::collection($companies);
    }

    public function show(Company $company)
    {
        $this->authorize('show', $company);

        return new CompanyResource($company);
    }

    public function store(CompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $created = Company::create($request->toArray());

        return $created;
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->code = request('code');
        $company->name = request('name');

        $company->save();

        return $company;
    }

    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();
    }
}
