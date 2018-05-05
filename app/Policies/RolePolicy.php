<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Role;
use App\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('roles.index') || $user->hasPermission('roles.all');
    }

    public function show(User $user, Role $role)
    {
        return $user->hasPermission('roles.show') || $user->hasPermission('roles.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('roles.create') || $user->hasPermission('roles.all');
    }

    public function update(User $user, Role $role)
    {
        return $user->hasPermission('roles.update') || $user->hasPermission('roles.all');
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('roles.delete') || $user->hasPermission('roles.all');
    }
}
