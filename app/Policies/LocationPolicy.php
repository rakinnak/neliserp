<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Location;
use App\User;

class LocationPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('locations.index') || $user->hasPermission('locations.all');
    }

    public function show(User $user, Location $location)
    {
        return $user->hasPermission('locations.show') || $user->hasPermission('locations.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('locations.create') || $user->hasPermission('locations.all');
    }

    public function update(User $user, Location $location)
    {
        return $user->hasPermission('locations.update') || $user->hasPermission('locations.all');
    }

    public function delete(User $user, Location $location)
    {
        return $user->hasPermission('locations.delete') || $user->hasPermission('locations.all');
    }
}
