<?php

namespace App\Http\Controllers\Api;

use App\Filters\ProvinceFilter;
use App\Province;
use App\Country;
use App\Http\Requests\ProvinceRequest;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\ProvinceCollection;

class ProvinceApi extends ApiController
{
    public function index(ProvinceFilter $filter)
    {
        $this->authorize('index', Province::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $provinces = Province::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return ProvinceResource::collection($provinces);
    }

    public function show(Province $province)
    {
        $this->authorize('show', $province);

        return new ProvinceResource($province);
    }

    public function store(ProvinceRequest $request)
    {
        $this->authorize('create', Province::class);

        $country = Country::find(request('country_id'));

        $created = Province::create([
            'code' => request('code'),
            'name' => request('name'),
            'country_id' => request('country_id'),
            'country_uuid' => $country->uuid,
        ]);

        return $created;
    }

    public function update(ProvinceRequest $request, Province $province)
    {
        $this->authorize('update', $province);

        $province->code = request('code');
        $province->name = request('name');

        $province->save();

        return $province;
    }

    public function destroy(Province $province)
    {
        $this->authorize('delete', $province);

        $province->delete();
    }
}
