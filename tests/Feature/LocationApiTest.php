<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Location;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    // *** locations.index ***

    /** @test */
    public function guest_user_cannot_index_locations()
    {
        $this->json('GET', route('api.locations.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_locations()
    {
        $this->signIn();

        $this->json('GET', route('api.locations.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_locations()
    {
        $this->signInWithPermission('locations.index');

        $location1 = factory(Location::class)->create();
        $location2 = factory(Location::class)->create();

        $this->json('GET', route('api.locations.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $location1->uuid,
                        'code' => $location1->code,
                        'name' => $location1->name,
                    ],
                    [
                        'uuid' => $location2->uuid,
                        'code' => $location2->code,
                        'name' => $location2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/locations?page=1',
                    'last' => 'http://localhost/api/locations?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/locations',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_locations_by_code()
    {
        $this->signInWithPermission('locations.index');

        $location_a1 = factory(Location::class)->create(['code' => 'a-001']);
        $location_a2 = factory(Location::class)->create(['code' => 'a-002']);
        $location_b1 = factory(Location::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.locations.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $location_a1->uuid,
                        'code' => $location_a1->code,
                        'name' => $location_a1->name,
                    ],
                    [
                        'uuid' => $location_a2->uuid,
                        'code' => $location_a2->code,
                        'name' => $location_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $location_b1->uuid,
                        'code' => $location_b1->code,
                        'name' => $location_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_locations_by_name()
    {
        $this->signInWithPermission('locations.index');

        $location_a1 = factory(Location::class)->create(['name' => 'a-001']);
        $location_a2 = factory(Location::class)->create(['name' => 'a-002']);
        $location_b1 = factory(Location::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.locations.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $location_a1->uuid,
                        'code' => $location_a1->code,
                        'name' => $location_a1->name,
                    ],
                    [
                        'uuid' => $location_a2->uuid,
                        'code' => $location_a2->code,
                        'name' => $location_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $location_b1->uuid,
                        'code' => $location_b1->code,
                        'name' => $location_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_locations_by_code_or_name()
    {
        $this->signInWithPermission('locations.index');

        $location_a1 = factory(Location::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $location_a2 = factory(Location::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $location_b1 = factory(Location::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $location_b2 = factory(Location::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.locations.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $location_a1->uuid,
                        'code' => $location_a1->code,
                        'name' => $location_a1->name,
                    ],
                    [
                        'uuid' => $location_a2->uuid,
                        'code' => $location_a2->code,
                        'name' => $location_a2->name,
                    ],
                    [
                        'uuid' => $location_b2->uuid,
                        'code' => $location_b2->code,
                        'name' => $location_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $location_b1->uuid,
                        'code' => $location_b1->code,
                        'name' => $location_b1->name,
                    ]
                ]
            ]);
    }

    // *** locations.show ***

    /** @test */
    public function guest_user_cannot_view_a_location()
    {
        $location1 = factory(Location::class)->create();

        $this->json('GET', route('api.locations.show', $location1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_location()
    {
        $this->signIn();

        $location1 = factory(Location::class)->create();

        $this->json('GET', route('api.locations.show', $location1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_location()
    {
        $this->signInWithPermission('locations.show');

        $location1 = factory(Location::class)->create();

        $this->json('GET', route('api.locations.show', $location1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $location1->uuid,
                    'code' => $location1->code,
                    'name' => $location1->name,
                ],
            ]);
    }

    // *** locations.store ***

    /** @test */
    public function guest_user_cannot_create_a_location()
    {
        $location1 = factory(Location::class)->make();

        $this->json('POST', route('api.locations.store'), $location1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_location()
    {
        $this->signIn();

        $location1 = factory(Location::class)->make();

        $this->json('POST', route('api.locations.store'), $location1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_location_requires_valid_fields()
    {
        $this->signInWithPermission('locations.create');

        $this->json('POST', route('api.locations.store'))
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
    public function authorized_user_can_create_a_location()
    {
        $this->signInWithPermission('locations.create');

        $location1 = factory(Location::class)->make();

        $this->json('POST', route('api.locations.store'),
            [
                'code' => $location1->code,
                'name' => $location1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('locations', [
            'code' => $location1->code,
            'name' => $location1->name,
        ]);
    }

    // create a new root location
    // create a child location under parent_id
    // move a location to be under parent_id
    // delete a child location
    // delete a parent location

    // *** locations.update ***

    /** @test */
    public function guest_user_cannot_update_a_location()
    {
        $location1 = factory(Location::class)->create();

        $location_updated = factory(Location::class)->make();

        $this->json('PATCH', route('api.locations.update', $location1->uuid),
            [
                'code' => $location_updated->code,
                'name' => $location_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_location()
    {
        $this->signIn();

        $location1 = factory(Location::class)->create();

        $location_updated = factory(Location::class)->make();

        $this->json('PATCH', route('api.locations.update', $location1->uuid),
            [
                'code' => $location_updated->code,
                'name' => $location_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_location_requires_valid_fields()
    {
        $this->signInWithPermission('locations.update');

        $location1 = factory(Location::class)->create();

        $this->json('PATCH', route('api.locations.update', $location1->uuid))
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
    public function authorized_user_can_update_a_location()
    {
        $this->signInWithPermission('locations.update');

        $location1 = factory(Location::class)->create();

        $location_updated = factory(Location::class)->make();

        $this->json('PATCH', route('api.locations.update', $location1->uuid),
            [
                'code' => $location_updated->code,
                'name' => $location_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('locations', [
            'id' => $location1->id,
            'uuid' => $location1->uuid,
            'code' => $location_updated->code,
            'name' => $location_updated->name,
        ]);
    }

    // *** locations.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_location()
    {
        $location1 = factory(Location::class)->create();

        $this->json('DELETE', route('api.locations.destroy', $location1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_location()
    {
        $this->signIn();

        $location1 = factory(Location::class)->create();

        $this->json('DELETE', route('api.locations.destroy', $location1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_location()
    {
        $this->signInWithPermission('locations.delete');

        $location1 = factory(Location::class)->create();

        $this->json('DELETE', route('api.locations.destroy', $location1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('locations', [
            'id' => $location1->id,
        ]);
    }
}
