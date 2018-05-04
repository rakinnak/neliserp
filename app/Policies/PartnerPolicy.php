<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Partner;
use App\User;

class PartnerPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('partners.index') || $user->hasPermission('partners.all');
    }

    public function show(User $user, Partner $partner)
    {
        return $user->hasPermission('partners.show') || $user->hasPermission('partners.all');
    }

    public function create(User $user)
    {
        return $user->hasPermission('partners.create') || $user->hasPermission('partners.all');
    }

    public function update(User $user, Partner $partner)
    {
        return $user->hasPermission('partners.update') || $user->hasPermission('partners.all');
    }

    public function delete(User $user, Partner $partner)
    {
        return $user->hasPermission('partners.delete') || $user->hasPermission('partners.all');
    }
}
