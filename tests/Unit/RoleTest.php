<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Permission;
use App\Role;
use App\User;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function role_has_permissions()
    {
        $role = factory(Role::class)->create();

        $this->assertInstanceOf(Collection::class, $role->permissions);
    }

    /** @test */
    public function role_has_users()
    {
        $role = factory(Role::class)->create();

        $this->assertInstanceOf(Collection::class, $role->users);
    }

    /** @test */
    public function role_can_give_permission_to()
    {
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();

        $role->givePermissionTo($permission);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }
}
