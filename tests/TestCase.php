<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;
use App\Permission;
use App\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $this;
    }

    protected function signInWithPermission($permission_name)
    {
        $permission = factory(Permission::class)->create(['name' => $permission_name]);

        $role = factory(Role::class)->create();
        $role->givePermissionTo($permission);

        $user = factory(User::class)->create();
        $user->assignRole($role->name);

        $this->actingAs($user);
    }
}
