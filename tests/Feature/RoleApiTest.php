<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Role;

class RoleApiTest extends TestCase
{
    use RefreshDatabase;

    // *** roles.index ***

    /** @test */
    public function guest_user_cannot_index_roles()
    {
        $this->json('GET', route('api.roles.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_roles()
    {
        $this->signIn();

        $this->json('GET', route('api.roles.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_roles()
    {
        $this->signInWithPermission('roles.index');

        $role1 = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();

        $user = auth()->user();

        $resonse = $this->json('GET', route('api.roles.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                ],
                'links' => [
                    'first' => 'http://localhost/api/roles?page=1',
                    'last' => 'http://localhost/api/roles?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/roles',
                    'per_page' => 10,
                    'to' => 3,          // +1 for $this->signInWithPermission()
                    'total' => 3        // +1 for $this->signInWithPermission()
                ],
            ])
            ->assertJsonFragment([
                'uuid' => $role1->uuid,
                'code' => $role1->code,
                'name' => $role1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $role2->uuid,
                'code' => $role2->code,
                'name' => $role2->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_roles_by_code()
    {
        $this->signInWithPermission('roles.index');

        $role_a1 = factory(Role::class)->create(['code' => 'a-001']);
        $role_a2 = factory(Role::class)->create(['code' => 'a-002']);
        $role_b1 = factory(Role::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.roles.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $role_a1->uuid,
                'code' => $role_a1->code,
                'name' => $role_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $role_a2->uuid,
                'code' => $role_a2->code,
                'name' => $role_a2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $role_b1->uuid,
                'code' => $role_b1->code,
                'name' => $role_b1->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_roles_by_name()
    {
        $this->signInWithPermission('roles.index');

        $role_a1 = factory(Role::class)->create(['name' => 'a-001']);
        $role_a2 = factory(Role::class)->create(['name' => 'a-002']);
        $role_b1 = factory(Role::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.roles.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $role_a1->uuid,
                'code' => $role_a1->code,
                'name' => $role_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $role_a2->uuid,
                'code' => $role_a2->code,
                'name' => $role_a2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $role_b1->uuid,
                'code' => $role_b1->code,
                'name' => $role_b1->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_roles_by_code_or_name()
    {
        $this->signInWithPermission('roles.index');

        $role_a1 = factory(Role::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $role_a2 = factory(Role::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $role_b1 = factory(Role::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $role_b2 = factory(Role::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.roles.index') . '?q=a')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $role_a1->uuid,
                'code' => $role_a1->code,
                'name' => $role_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $role_a2->uuid,
                'code' => $role_a2->code,
                'name' => $role_a2->name,
            ])

            ->assertJsonFragment([
                'uuid' => $role_b2->uuid,
                'code' => $role_b2->code,
                'name' => $role_b2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $role_b1->uuid,
                'code' => $role_b1->code,
                'name' => $role_b1->name,
            ]);
    }

    // *** roles.show ***

    /** @test */
    public function guest_user_cannot_view_a_role()
    {
        $role1 = factory(Role::class)->create();

        $this->json('GET', route('api.roles.show', $role1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_role()
    {
        $this->signIn();

        $role1 = factory(Role::class)->create();

        $this->json('GET', route('api.roles.show', $role1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_role()
    {
        $this->signInWithPermission('roles.show');

        $role1 = factory(Role::class)->create();

        $this->json('GET', route('api.roles.show', $role1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $role1->uuid,
                    'code' => $role1->code,
                    'name' => $role1->name,
                ],
            ]);
    }

    // *** roles.store ***

    /** @test */
    public function guest_user_cannot_create_a_role()
    {
        $role1 = factory(Role::class)->make();

        $this->json('POST', route('api.roles.store'), $role1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_role()
    {
        $this->signIn();

        $role1 = factory(Role::class)->make();

        $this->json('POST', route('api.roles.store'), $role1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_role_requires_valid_fields()
    {
        $this->signInWithPermission('roles.create');

        $this->json('POST', route('api.roles.store'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_create_a_role()
    {
        $this->signInWithPermission('roles.create');

        $role1 = factory(Role::class)->make();

        $this->json('POST', route('api.roles.store'),
            [
                'code' => $role1->code,
                'name' => $role1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('roles', [
            'code' => $role1->code,
            'name' => $role1->name,
        ]);
    }

    // *** roles.update ***

    /** @test */
    public function guest_user_cannot_update_a_role()
    {
        $role1 = factory(Role::class)->create();

        $role_updated = factory(Role::class)->make();

        $this->json('PATCH', route('api.roles.update', $role1->uuid),
            [
                'code' => $role_updated->code,
                'name' => $role_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_role()
    {
        $this->signIn();

        $role1 = factory(Role::class)->create();

        $role_updated = factory(Role::class)->make();

        $this->json('PATCH', route('api.roles.update', $role1->uuid),
            [
                'code' => $role_updated->code,
                'name' => $role_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_role_requires_valid_fields()
    {
        $this->signInWithPermission('roles.update');

        $role1 = factory(Role::class)->create();

        $this->json('PATCH', route('api.roles.update', $role1->uuid))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_update_a_role()
    {
        $this->signInWithPermission('roles.update');

        $role1 = factory(Role::class)->create();

        $role_updated = factory(Role::class)->make();

        $this->json('PATCH', route('api.roles.update', $role1->uuid),
            [
                'code' => $role_updated->code,
                'name' => $role_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('roles', [
            'id' => $role1->id,
            'uuid' => $role1->uuid,
            'code' => $role_updated->code,
            'name' => $role_updated->name,
        ]);
    }

    // *** roles.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_role()
    {
        $role1 = factory(Role::class)->create();

        $this->json('DELETE', route('api.roles.destroy', $role1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_role()
    {
        $this->signIn();

        $role1 = factory(Role::class)->create();

        $this->json('DELETE', route('api.roles.destroy', $role1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_role()
    {
        $this->signInWithPermission('roles.delete');

        $role1 = factory(Role::class)->create();

        $this->json('DELETE', route('api.roles.destroy', $role1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('roles', [
            'id' => $role1->id,
        ]);
    }
}
