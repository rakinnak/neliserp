<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('users.index') || $user->hasPermission('users.all');
    }

    public function show(User $user, User $logged_user)
    {
        return $user->hasPermission('users.show') || $user->hasPermission('users.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('users.create') || $user->hasPermission('users.all');
    }

    public function update(User $user, User $logged_user)
    {
        return $user->hasPermission('users.update') || $user->hasPermission('users.all');
    }

    public function delete(User $user, User $logged_user)
    {
        return $user->hasPermission('users.delete') || $user->hasPermission('users.all');
    }
}
