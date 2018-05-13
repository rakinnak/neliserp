<?php

namespace App\Http\Controllers\Api;

use App\Filters\CountryFilter;
use App\Country;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;

class CountryApi extends ApiController
{
    public function index(CountryFilter $filter)
    {
        $this->authorize('index', Country::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $countries = Country::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return CountryResource::collection($countries);
    }

    public function show(Country $country)
    {
        $this->authorize('show', $country);

        return new CountryResource($country);
    }

    public function store(CountryRequest $request)
    {
        $this->authorize('create', Country::class);

        $created = Country::create([
            'code' => request('code'),
            'name' => request('name'),
        ]);

        return $created;
    }

    public function update(CountryRequest $request, Country $country)
    {
        $this->authorize('update', $country);

        $country->code = request('code');
        $country->name = request('name');

        $country->save();

        return $country;
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        $country->delete();
    }
}
