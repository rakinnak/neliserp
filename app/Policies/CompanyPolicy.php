<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Company;
use App\User;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('companies.index') || $user->hasPermission('companies.all');
    }

    public function show(User $user, Company $item)
    {
        return $user->hasPermission('companies.show') || $user->hasPermission('companies.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('companies.create') || $user->hasPermission('companies.all');
    }

    public function update(User $user, Company $item)
    {
        return $user->hasPermission('companies.update') || $user->hasPermission('companies.all');
    }

    public function delete(User $user, Company $item)
    {
        return $user->hasPermission('companies.delete') || $user->hasPermission('companies.all');
    }
}
