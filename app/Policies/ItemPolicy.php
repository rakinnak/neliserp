<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Item;
use App\User;

class ItemPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('items.index') || $user->hasPermission('items.all');
    }

    public function show(User $user, Item $item)
    {
        return $user->hasPermission('items.show') || $user->hasPermission('items.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('items.create') || $user->hasPermission('items.all');
    }

    public function update(User $user, Item $item)
    {
        return $user->hasPermission('items.update') || $user->hasPermission('items.all');
    }

    public function delete(User $user, Item $item)
    {
        return $user->hasPermission('items.delete') || $user->hasPermission('items.all');
    }
}
