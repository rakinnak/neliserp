<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Permission;
use App\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('permissions.index') || $user->hasPermission('permissions.all');
    }

    public function show(User $user, Permission $permission)
    {
        return $user->hasPermission('permissions.show') || $user->hasPermission('permissions.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('permissions.create') || $user->hasPermission('permissions.all');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->hasPermission('permissions.update') || $user->hasPermission('permissions.all');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasPermission('permissions.delete') || $user->hasPermission('permissions.all');
    }
}
