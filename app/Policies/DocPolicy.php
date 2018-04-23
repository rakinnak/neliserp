<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Doc;
use App\User;

class DocPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('docs.index') || $user->hasPermission('docs.all');
    }

    public function show(User $user, Doc $item)
    {
        return $user->hasPermission('docs.show') || $user->hasPermission('docs.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('docs.create') || $user->hasPermission('docs.all');
    }

    public function update(User $user, Doc $item)
    {
        return $user->hasPermission('docs.update') || $user->hasPermission('docs.all');
    }

    public function delete(User $user, Doc $item)
    {
        return $user->hasPermission('docs.delete') || $user->hasPermission('docs.all');
    }
}
