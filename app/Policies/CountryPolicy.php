<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Country;
use App\User;

class CountryPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('countries.index') || $user->hasPermission('countries.all');
    }

    public function show(User $user, Country $country)
    {
        return $user->hasPermission('countries.show') || $user->hasPermission('countries.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('countries.create') || $user->hasPermission('countries.all');
    }

    public function update(User $user, Country $country)
    {
        return $user->hasPermission('countries.update') || $user->hasPermission('countries.all');
    }

    public function delete(User $user, Country $country)
    {
        return $user->hasPermission('countries.delete') || $user->hasPermission('countries.all');
    }
}
