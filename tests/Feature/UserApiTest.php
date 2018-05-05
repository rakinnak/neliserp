<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

//class UserApiTest extends TestCase
//{
//    use RefreshDatabase;
//
//    // *** users.index ***
//
//    /** @test */
//    public function guest_user_cannot_index_users()
//    {
//        $this->json('GET', route('api.users.index'))
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function unauthorized_user_denied_to_index_users()
//    {
//        $this->signIn();
//
//        $this->json('GET', route('api.users.index'))
//            ->assertStatus(403);
//    }
//
//    /** @test */
//    public function authorized_user_can_index_users()
//    {
//        $this->signInWithPermission('users.index');
//
//        $user1 = factory(User::class)->create();
//        $user2 = factory(User::class)->create();
//
//        $user = auth()->user();
//
//        $this->json('GET', route('api.users.index'))
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $user1->uuid,
//                        'code' => $user1->code,
//                        'name' => $user1->name,
//                    ],
//                    [
//                        'uuid' => $user2->uuid,
//                        'code' => $user2->code,
//                        'name' => $user2->name,
//                    ]
//                ],
//                'links' => [
//                    'first' => 'http://localhost/api/users?page=1',
//                    'last' => 'http://localhost/api/users?page=1',
//                    'prev' => null,
//                    'next' => null
//                ],
//                'meta' => [
//                    'current_page' => 1,
//                    'from' => 1,
//                    'last_page' => 1,
//                    'path' => 'http://localhost/api/users',
//                    'per_page' => 10,
//                    'to' => 2,
//                    'total' => 2
//                ],
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_filter_users_by_code()
//    {
//        $this->signInWithPermission('users.index');
//
//        $user_a1 = factory(User::class)->create(['code' => 'a-001']);
//        $user_a2 = factory(User::class)->create(['code' => 'a-002']);
//        $user_b1 = factory(User::class)->create(['code' => 'b-001']);
//
//        $this->json('GET', route('api.users.index') . '?code=a-00')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $user_a1->uuid,
//                        'code' => $user_a1->code,
//                        'name' => $user_a1->name,
//                    ],
//                    [
//                        'uuid' => $user_a2->uuid,
//                        'code' => $user_a2->code,
//                        'name' => $user_a2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $user_b1->uuid,
//                        'code' => $user_b1->code,
//                        'name' => $user_b1->name,
//                    ]
//                ]
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_filter_users_by_name()
//    {
//        $this->signInWithPermission('users.index');
//
//        $user_a1 = factory(User::class)->create(['name' => 'a-001']);
//        $user_a2 = factory(User::class)->create(['name' => 'a-002']);
//        $user_b1 = factory(User::class)->create(['name' => 'b-001']);
//
//        $this->json('GET', route('api.users.index') . '?name=a-00')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $user_a1->uuid,
//                        'code' => $user_a1->code,
//                        'name' => $user_a1->name,
//                    ],
//                    [
//                        'uuid' => $user_a2->uuid,
//                        'code' => $user_a2->code,
//                        'name' => $user_a2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $user_b1->uuid,
//                        'code' => $user_b1->code,
//                        'name' => $user_b1->name,
//                    ]
//                ]
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_filter_users_by_code_or_name()
//    {
//        $this->signInWithPermission('users.index');
//
//        $user_a1 = factory(User::class)->create(['code' => 'a-001', 'name' => 'c-001']);
//        $user_a2 = factory(User::class)->create(['code' => 'a-002', 'name' => 'c-002']);
//        $user_b1 = factory(User::class)->create(['code' => 'b-001', 'name' => 'c-003']);
//        $user_b2 = factory(User::class)->create(['code' => 'b-002', 'name' => 'a-004']);
//
//        $this->json('GET', route('api.users.index') . '?q=a')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $user_a1->uuid,
//                        'code' => $user_a1->code,
//                        'name' => $user_a1->name,
//                    ],
//                    [
//                        'uuid' => $user_a2->uuid,
//                        'code' => $user_a2->code,
//                        'name' => $user_a2->name,
//                    ],
//                    [
//                        'uuid' => $user_b2->uuid,
//                        'code' => $user_b2->code,
//                        'name' => $user_b2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $user_b1->uuid,
//                        'code' => $user_b1->code,
//                        'name' => $user_b1->name,
//                    ]
//                ]
//            ]);
//    }
//
//    // *** users.show ***
//
//    /** @test */
//    public function guest_user_cannot_view_a_user()
//    {
//        $user1 = factory(User::class)->create();
//
//        $this->json('GET', route('api.users.show', $user1->uuid))
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function unauthorized_user_denied_to_view_a_user()
//    {
//        $this->signIn();
//
//        $user1 = factory(User::class)->create();
//
//        $this->json('GET', route('api.users.show', $user1->uuid))
//            ->assertStatus(403);
//    }
//
//    /** @test */
//    public function authorized_user_can_view_a_user()
//    {
//        $this->signInWithPermission('users.show');
//
//        $user1 = factory(User::class)->create();
//
//        $this->json('GET', route('api.users.show', $user1->uuid))
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    'uuid' => $user1->uuid,
//                    'code' => $user1->code,
//                    'name' => $user1->name,
//                ],
//            ]);
//    }
//
//    // *** users.store ***
//
//    /** @test */
//    public function guest_user_cannot_create_a_user()
//    {
//        $user1 = factory(User::class)->make();
//
//        $this->json('POST', route('api.users.store'), $user1->toArray())
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function unauthorized_user_denied_to_create_a_user()
//    {
//        $this->signIn();
//
//        $user1 = factory(User::class)->make();
//
//        $this->json('POST', route('api.users.store'), $user1->toArray())
//            ->assertStatus(403);
//    }
//
//    /**  @test */
//    public function create_a_user_requires_valid_fields()
//    {
//        $this->signInWithPermission('users.create');
//
//        $this->json('POST', route('api.users.store'))
//            ->assertStatus(422)
//            ->assertJson([
//                'message' => 'The given data was invalid.',
//                'errors' => [
//                    'code' => [
//                        'The code field is required.'
//                    ],
//                    'name' => [
//                        'The name field is required.'
//                    ],
//                ],
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_create_a_user()
//    {
//        $this->signInWithPermission('users.create');
//
//        $user1 = factory(User::class)->make();
//
//        $this->json('POST', route('api.users.store'),
//            [
//                'code' => $user1->code,
//                'name' => $user1->name,
//            ])
//            ->assertStatus(201);
//
//        $this->assertDatabaseHas('users', [
//            'code' => $user1->code,
//            'name' => $user1->name,
//        ]);
//    }
//
//    // *** users.update ***
//
//    /** @test */
//    public function guest_user_cannot_update_a_user()
//    {
//        $user1 = factory(User::class)->create();
//
//        $user_updated = factory(User::class)->make();
//
//        $this->json('PATCH', route('api.users.update', $user1->uuid),
//            [
//                'code' => $user_updated->code,
//                'name' => $user_updated->name,
//            ])
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function unauthorized_user_denied_to_update_a_user()
//    {
//        $this->signIn();
//
//        $user1 = factory(User::class)->create();
//
//        $user_updated = factory(User::class)->make();
//
//        $this->json('PATCH', route('api.users.update', $user1->uuid),
//            [
//                'code' => $user_updated->code,
//                'name' => $user_updated->name,
//            ])
//            ->assertStatus(403);
//    }
//
//    /**  @test */
//    public function update_a_user_requires_valid_fields()
//    {
//        $this->signInWithPermission('users.update');
//
//        $user1 = factory(User::class)->create();
//
//        $this->json('PATCH', route('api.users.update', $user1->uuid))
//            ->assertStatus(422)
//            ->assertJson([
//                'message' => 'The given data was invalid.',
//                'errors' => [
//                    'code' => [
//                        'The code field is required.'
//                    ],
//                    'name' => [
//                        'The name field is required.'
//                    ],
//                ],
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_update_a_user()
//    {
//        $this->signInWithPermission('users.update');
//
//        $user1 = factory(User::class)->create();
//
//        $user_updated = factory(User::class)->make();
//
//        $this->json('PATCH', route('api.users.update', $user1->uuid),
//            [
//                'code' => $user_updated->code,
//                'name' => $user_updated->name,
//            ])
//            ->assertStatus(200);
//
//        $this->assertDatabaseHas('users', [
//            'id' => $user1->id,
//            'uuid' => $user1->uuid,
//            'code' => $user_updated->code,
//            'name' => $user_updated->name,
//        ]);
//    }
//
//    // *** users.delete ***
//
//    /** @test */
//    public function guest_user_cannot_delete_a_user()
//    {
//        $user1 = factory(User::class)->create();
//
//        $this->json('DELETE', route('api.users.destroy', $user1->uuid))
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function unauthorized_user_denied_to_delete_a_user()
//    {
//        $this->signIn();
//
//        $user1 = factory(User::class)->create();
//
//        $this->json('DELETE', route('api.users.destroy', $user1->uuid))
//            ->assertStatus(403);
//    }
//
//    /** @test */
//    public function authorized_user_can_delete_a_user()
//    {
//        $this->signInWithPermission('users.delete');
//
//        $user1 = factory(User::class)->create();
//
//        $this->json('DELETE', route('api.users.destroy', $user1->uuid))
//            ->assertStatus(200);
//
//        $this->assertDatabaseMissing('users', [
//            'id' => $user1->id,
//        ]);
//    }
//}
