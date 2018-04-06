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
        return $user->hasPermission('items.index');
    }

    public function show(User $user, Item $item)
    {
        return $user->hasPermission('items.show');
    }

    public function create(User $user)
    {
        return $user->hasPermission('items.create');
    }

    public function update(User $user, Item $item)
    {
        return $user->hasPermission('items.update');
    }

    public function delete(User $user, Item $item)
    {
        return $user->hasPermission('items.delete');
    }
}
