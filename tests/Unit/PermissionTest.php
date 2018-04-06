<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Permission;
use App\Role;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function permission_has_roles()
    {
        $permission = factory(Permission::class)->create();

        $this->assertInstanceOf(Collection::class, $permission->roles);
    }
}
