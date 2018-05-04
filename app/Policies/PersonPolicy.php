<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Person;
use App\User;

class PersonPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('persons.index') || $user->hasPermission('persons.all');
    }

    public function show(User $user, Person $person)
    {
        return $user->hasPermission('persons.show') || $user->hasPermission('persons.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('persons.create') || $user->hasPermission('persons.all');
    }

    public function update(User $user, Person $person)
    {
        return $user->hasPermission('persons.update') || $user->hasPermission('persons.all');
    }

    public function delete(User $user, Person $person)
    {
        return $user->hasPermission('persons.delete') || $user->hasPermission('persons.all');
    }
}
