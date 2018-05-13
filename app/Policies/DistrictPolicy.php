<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\District;
use App\User;

class DistrictPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('districts.index') || $user->hasPermission('districts.all');
    }

    public function show(User $user, District $district)
    {
        return $user->hasPermission('districts.show') || $user->hasPermission('districts.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('districts.create') || $user->hasPermission('districts.all');
    }

    public function update(User $user, District $district)
    {
        return $user->hasPermission('districts.update') || $user->hasPermission('districts.all');
    }

    public function delete(User $user, District $district)
    {
        return $user->hasPermission('districts.delete') || $user->hasPermission('districts.all');
    }
}
