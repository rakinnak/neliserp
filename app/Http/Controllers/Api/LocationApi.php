<?php

namespace App\Http\Controllers\Api;

use App\Filters\LocationFilter;
use App\Location;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationCollection;

class LocationApi extends ApiController
{
    public function index(LocationFilter $filter)
    {
        $this->authorize('index', Location::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $locations = Location::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return LocationResource::collection($locations);
    }

    public function show(Location $location)
    {
        $this->authorize('show', $location);

        return new LocationResource($location);
    }

    public function store(LocationRequest $request)
    {
        $this->authorize('create', Location::class);

        $created = Location::create([
            'code' => request('code'),
            'name' => request('name'),
            'parent_uuid' => $request['parent_uuid'],
            'parent_id' => $request['parent_uuid'] ? Location::where('uuid', $request['parent_uuid'])->first()->id : null,
        ]);

        return $created;
    }

    public function update(LocationRequest $request, Location $location)
    {
        $this->authorize('update', $location);

        $location->code = request('code');
        $location->name = request('name');

        $location->save();

        return $location;
    }

    public function destroy(Location $location)
    {
        $this->authorize('delete', $location);

        $location->delete();
    }
}
