<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Permission;

class PermissionApiTest extends TestCase
{
    use RefreshDatabase;

    // *** permissions.index ***

    /** @test */
    public function guest_user_cannot_index_permissions()
    {
        $this->json('GET', route('api.permissions.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_permissions()
    {
        $this->signIn();

        $this->json('GET', route('api.permissions.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_permissions()
    {
        $this->signInWithPermission('permissions.index');

        $permission1 = factory(Permission::class)->create();
        $permission2 = factory(Permission::class)->create();

        $user = auth()->user();

        $resonse = $this->json('GET', route('api.permissions.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                ],
                'links' => [
                    'first' => 'http://localhost/api/permissions?page=1',
                    'last' => 'http://localhost/api/permissions?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/permissions',
                    'per_page' => 10,
                    'to' => 3,          // +1 for $this->signInWithPermission()
                    'total' => 3        // +1 for $this->signInWithPermission()
                ],
            ])
            ->assertJsonFragment([
                'uuid' => $permission1->uuid,
                'code' => $permission1->code,
                'name' => $permission1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $permission2->uuid,
                'code' => $permission2->code,
                'name' => $permission2->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_permissions_by_code()
    {
        $this->signInWithPermission('permissions.index');

        $permission_a1 = factory(Permission::class)->create(['code' => 'a-001']);
        $permission_a2 = factory(Permission::class)->create(['code' => 'a-002']);
        $permission_b1 = factory(Permission::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.permissions.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $permission_a1->uuid,
                'code' => $permission_a1->code,
                'name' => $permission_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $permission_a2->uuid,
                'code' => $permission_a2->code,
                'name' => $permission_a2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $permission_b1->uuid,
                'code' => $permission_b1->code,
                'name' => $permission_b1->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_permissions_by_name()
    {
        $this->signInWithPermission('permissions.index');

        $permission_a1 = factory(Permission::class)->create(['name' => 'a-001']);
        $permission_a2 = factory(Permission::class)->create(['name' => 'a-002']);
        $permission_b1 = factory(Permission::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.permissions.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $permission_a1->uuid,
                'code' => $permission_a1->code,
                'name' => $permission_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $permission_a2->uuid,
                'code' => $permission_a2->code,
                'name' => $permission_a2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $permission_b1->uuid,
                'code' => $permission_b1->code,
                'name' => $permission_b1->name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_permissions_by_code_or_name()
    {
        $this->signInWithPermission('permissions.index');

        $permission_a1 = factory(Permission::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $permission_a2 = factory(Permission::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $permission_b1 = factory(Permission::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $permission_b2 = factory(Permission::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.permissions.index') . '?q=a')
            ->assertStatus(200)
            ->assertJsonFragment([
                'uuid' => $permission_a1->uuid,
                'code' => $permission_a1->code,
                'name' => $permission_a1->name,
            ])
            ->assertJsonFragment([
                'uuid' => $permission_a2->uuid,
                'code' => $permission_a2->code,
                'name' => $permission_a2->name,
            ])

            ->assertJsonFragment([
                'uuid' => $permission_b2->uuid,
                'code' => $permission_b2->code,
                'name' => $permission_b2->name,
            ])
            ->assertJsonMissing([
                'uuid' => $permission_b1->uuid,
                'code' => $permission_b1->code,
                'name' => $permission_b1->name,
            ]);
    }

    // *** permissions.show ***

    /** @test */
    public function guest_user_cannot_view_a_permission()
    {
        $permission1 = factory(Permission::class)->create();

        $this->json('GET', route('api.permissions.show', $permission1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_permission()
    {
        $this->signIn();

        $permission1 = factory(Permission::class)->create();

        $this->json('GET', route('api.permissions.show', $permission1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_permission()
    {
        $this->signInWithPermission('permissions.show');

        $permission1 = factory(Permission::class)->create();

        $this->json('GET', route('api.permissions.show', $permission1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $permission1->uuid,
                    'code' => $permission1->code,
                    'name' => $permission1->name,
                ],
            ]);
    }

    // *** permissions.store ***

    // /** @test */
    // public function guest_user_cannot_create_a_permission()
    // {
    //     $permission1 = factory(Permission::class)->make();

    //     $this->json('POST', route('api.permissions.store'), $permission1->toArray())
    //         ->assertStatus(401);
    // }

    // /** @test */
    // public function unauthorized_user_denied_to_create_a_permission()
    // {
    //     $this->signIn();

    //     $permission1 = factory(Permission::class)->make();

    //     $this->json('POST', route('api.permissions.store'), $permission1->toArray())
    //         ->assertStatus(403);
    // }

    // /**  @test */
    // public function create_a_permission_requires_valid_fields()
    // {
    //     $this->signInWithPermission('permissions.create');

    //     $this->json('POST', route('api.permissions.store'))
    //         ->assertStatus(422)
    //         ->assertJson([
    //             'message' => 'The given data was invalid.',
    //             'errors' => [
    //                 'code' => [
    //                     'The code field is required.'
    //                 ],
    //                 'name' => [
    //                     'The name field is required.'
    //                 ],
    //             ],
    //         ]);
    // }

    // /** @test */
    // public function authorized_user_can_create_a_permission()
    // {
    //     $this->signInWithPermission('permissions.create');

    //     $permission1 = factory(Permission::class)->make();

    //     $this->json('POST', route('api.permissions.store'),
    //         [
    //             'code' => $permission1->code,
    //             'name' => $permission1->name,
    //         ])
    //         ->assertStatus(201);

    //     $this->assertDatabaseHas('permissions', [
    //         'code' => $permission1->code,
    //         'name' => $permission1->name,
    //     ]);
    // }

    // // *** permissions.update ***

    // /** @test */
    // public function guest_user_cannot_update_a_permission()
    // {
    //     $permission1 = factory(Permission::class)->create();

    //     $permission_updated = factory(Permission::class)->make();

    //     $this->json('PATCH', route('api.permissions.update', $permission1->uuid),
    //         [
    //             'code' => $permission_updated->code,
    //             'name' => $permission_updated->name,
    //         ])
    //         ->assertStatus(401);
    // }

    // /** @test */
    // public function unauthorized_user_denied_to_update_a_permission()
    // {
    //     $this->signIn();

    //     $permission1 = factory(Permission::class)->create();

    //     $permission_updated = factory(Permission::class)->make();

    //     $this->json('PATCH', route('api.permissions.update', $permission1->uuid),
    //         [
    //             'code' => $permission_updated->code,
    //             'name' => $permission_updated->name,
    //         ])
    //         ->assertStatus(403);
    // }

    // /**  @test */
    // public function update_a_permission_requires_valid_fields()
    // {
    //     $this->signInWithPermission('permissions.update');

    //     $permission1 = factory(Permission::class)->create();

    //     $this->json('PATCH', route('api.permissions.update', $permission1->uuid))
    //         ->assertStatus(422)
    //         ->assertJson([
    //             'message' => 'The given data was invalid.',
    //             'errors' => [
    //                 'code' => [
    //                     'The code field is required.'
    //                 ],
    //                 'name' => [
    //                     'The name field is required.'
    //                 ],
    //             ],
    //         ]);
    // }

    // /** @test */
    // public function authorized_user_can_update_a_permission()
    // {
    //     $this->signInWithPermission('permissions.update');

    //     $permission1 = factory(Permission::class)->create();

    //     $permission_updated = factory(Permission::class)->make();

    //     $this->json('PATCH', route('api.permissions.update', $permission1->uuid),
    //         [
    //             'code' => $permission_updated->code,
    //             'name' => $permission_updated->name,
    //         ])
    //         ->assertStatus(200);

    //     $this->assertDatabaseHas('permissions', [
    //         'id' => $permission1->id,
    //         'uuid' => $permission1->uuid,
    //         'code' => $permission_updated->code,
    //         'name' => $permission_updated->name,
    //     ]);
    // }

    // // *** permissions.delete ***

    // /** @test */
    // public function guest_user_cannot_delete_a_permission()
    // {
    //     $permission1 = factory(Permission::class)->create();

    //     $this->json('DELETE', route('api.permissions.destroy', $permission1->uuid))
    //         ->assertStatus(401);
    // }

    // /** @test */
    // public function unauthorized_user_denied_to_delete_a_permission()
    // {
    //     $this->signIn();

    //     $permission1 = factory(Permission::class)->create();

    //     $this->json('DELETE', route('api.permissions.destroy', $permission1->uuid))
    //         ->assertStatus(403);
    // }

    // /** @test */
    // public function authorized_user_can_delete_a_permission()
    // {
    //     $this->signInWithPermission('permissions.delete');

    //     $permission1 = factory(Permission::class)->create();

    //     $this->json('DELETE', route('api.permissions.destroy', $permission1->uuid))
    //         ->assertStatus(200);

    //     $this->assertDatabaseMissing('permissions', [
    //         'id' => $permission1->id,
    //     ]);
    // }
}
