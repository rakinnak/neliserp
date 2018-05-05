<?php

namespace App\Http\Controllers\Api;

use App\Filters\PersonFilter;
use App\Person;
use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonResource;

class PersonApi extends ApiController
{
    public function index(PersonFilter $filter)
    {
        $this->authorize('index', Person::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $persons = Person::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return PersonResource::collection($persons);
    }

    public function show(Person $person)
    {
        $this->authorize('show', $person);

        return new PersonResource($person);
    }

    public function store(PersonRequest $request)
    {
        $this->authorize('create', Person::class);

        $created = Person::create($request->toArray());

        return $created;
    }

    public function update(PersonRequest $request, Person $person)
    {
        $this->authorize('update', $person);

        $person->code = request('code');
        $person->first_name = request('first_name');
        $person->last_name = request('last_name');

        $person->save();

        return $person;
    }

    public function destroy(Person $person)
    {
        $this->authorize('delete', $person);

        $person->delete();
    }
}
