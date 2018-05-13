<?php

namespace App\Http\Controllers\Api;

use App\Filters\DistrictFilter;
use App\District;
use App\Province;
use App\Http\Requests\DistrictRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DistrictCollection;

class DistrictApi extends ApiController
{
    public function index(DistrictFilter $filter)
    {
        $this->authorize('index', District::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $districts = District::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return DistrictResource::collection($districts);
    }

    public function show(District $district)
    {
        $this->authorize('show', $district);

        return new DistrictResource($district);
    }

    public function store(DistrictRequest $request)
    {
        $this->authorize('create', District::class);

        $province = Province::find(request('province_id'));

        $created = District::create([
            'code' => request('code'),
            'name' => request('name'),
            'province_id' => request('province_id'),
            'province_uuid' => $province->uuid,
        ]);

        return $created;
    }

    public function update(DistrictRequest $request, District $district)
    {
        $this->authorize('update', $district);

        $district->code = request('code');
        $district->name = request('name');

        $district->save();

        return $district;
    }

    public function destroy(District $district)
    {
        $this->authorize('delete', $district);

        $district->delete();
    }
}
