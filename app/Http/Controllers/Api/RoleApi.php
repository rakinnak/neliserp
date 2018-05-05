<?php

namespace App\Http\Controllers\Api;

use App\Filters\RoleFilter;
use App\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;

class RoleApi extends ApiController
{
    public function index(RoleFilter $filter)
    {
        $this->authorize('index', Role::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $roles = Role::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return RoleResource::collection($roles);
    }

    public function show(Role $role)
    {
        $this->authorize('show', $role);

        return new RoleResource($role);
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $created = Role::create($request->toArray());

        return $created;
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->code = request('code');
        $role->name = request('name');

        $role->save();

        return $role;
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $role->delete();
    }
}
