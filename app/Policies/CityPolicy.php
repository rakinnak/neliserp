<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\City;
use App\User;

class CityPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('cities.index') || $user->hasPermission('cities.all');
    }

    public function show(User $user, City $city)
    {
        return $user->hasPermission('cities.show') || $user->hasPermission('cities.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('cities.create') || $user->hasPermission('cities.all');
    }

    public function update(User $user, City $city)
    {
        return $user->hasPermission('cities.update') || $user->hasPermission('cities.all');
    }

    public function delete(User $user, City $city)
    {
        return $user->hasPermission('cities.delete') || $user->hasPermission('cities.all');
    }
}
