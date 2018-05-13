<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Province;
use App\User;

class ProvincePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('provinces.index') || $user->hasPermission('provinces.all');
    }

    public function show(User $user, Province $province)
    {
        return $user->hasPermission('provinces.show') || $user->hasPermission('provinces.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('provinces.create') || $user->hasPermission('provinces.all');
    }

    public function update(User $user, Province $province)
    {
        return $user->hasPermission('provinces.update') || $user->hasPermission('provinces.all');
    }

    public function delete(User $user, Province $province)
    {
        return $user->hasPermission('provinces.delete') || $user->hasPermission('provinces.all');
    }
}
