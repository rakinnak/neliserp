<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Permission;
use App\Role;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_roles()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->roles);
    }

    /** @test */
    public function user_can_be_assigned_role_by_role_name()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user->assignRole($role->name);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function user_can_check_permission_by_name()
    {
        $user = factory(User::class)->create();
        $permission = factory(Permission::class)->create();
        $role = factory(Role::class)->create();

        $role->givePermissionTo($permission);
        $user->assignRole($role->name);

        $this->assertTrue($user->hasPermission($permission->name));

    }
}
