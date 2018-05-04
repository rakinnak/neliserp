<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Partner;
use App\Filters\PartnerFilter;
use App\Http\Requests\PartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\PartnerCollection;

class PartnerApi extends ApiController
{
    public function index(PartnerFilter $filter, $role)
    {
        $this->authorize('index', Partner::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $partners = Partner::filter($filter)
            ->where("is_{$role}", true)
            ->paginate($per_page); // TODO: per page configuration

        return PartnerResource::collection($partners);
    }

    public function show($role, Partner $partner)
    {
        $this->authorize('show', $partner);

        return new PartnerResource($partner);
    }

    public function store($role, PartnerRequest $request)
    {
        $this->authorize('create', Partner::class);

        $company = Company::create([
            'code' => $request['code'],
            'name' => $request['name'],
        ]);

        $created = Partner::create([
            'subject_type' => 'App\Company',
            'subject_id' => $company->id,
            'subject_uuid' => $company->uuid,
            'code' => $request['code'],
            'name' => $request['name'],
            'is_customer' => ($role == 'customer'),
            'is_supplier' => ($role == 'supplier'),
        ]);

        return $created;
    }

    public function update(PartnerRequest $request, $type, Partner $partner)
    {
        $this->authorize('update', $partner);

        $partner->code = request('code');
        $partner->name = request('name');

        $partner->save();

        return $partner;
    }

    public function destroy($type, Partner $partner)
    {
        $this->authorize('delete', $partner);

        $partner->delete();
    }
}
