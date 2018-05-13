<?php

namespace App\Http\Controllers\Api;

use App\Filters\CityFilter;
use App\City;
use App\District;
use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\CityCollection;

class CityApi extends ApiController
{
    public function index(CityFilter $filter)
    {
        $this->authorize('index', City::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $cities = City::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return CityResource::collection($cities);
    }

    public function show(City $city)
    {
        $this->authorize('show', $city);

        return new CityResource($city);
    }

    public function store(CityRequest $request)
    {
        $this->authorize('create', City::class);

        $district = District::find(request('district_id'));

        $created = City::create([
            'code' => request('code'),
            'name' => request('name'),
            'district_id' => request('district_id'),
            'district_uuid' => $district->uuid,
        ]);

        return $created;
    }

    public function update(CityRequest $request, City $city)
    {
        $this->authorize('update', $city);

        $city->code = request('code');
        $city->name = request('name');

        $city->save();

        return $city;
    }

    public function destroy(City $city)
    {
        $this->authorize('delete', $city);

        $city->delete();
    }
}
