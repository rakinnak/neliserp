<?php

namespace App\Http\Controllers\Api;

use App\Filters\PermissionFilter;
use App\Permission;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;

class PermissionApi extends ApiController
{
    public function index(PermissionFilter $filter)
    {
        $this->authorize('index', Permission::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $permissions = Permission::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return PermissionResource::collection($permissions);
    }

    public function show(Permission $permission)
    {
        $this->authorize('show', $permission);

        return new PermissionResource($permission);
    }

    public function store(PermissionRequest $request)
    {
        $this->authorize('create', Permission::class);

        $created = Permission::create($request->toArray());

        return $created;
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $permission->code = request('code');
        $permission->name = request('name');

        $permission->save();

        return $permission;
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);

        $permission->delete();
    }
}
