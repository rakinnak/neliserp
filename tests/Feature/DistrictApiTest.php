<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\District;

class DistrictApiTest extends TestCase
{
    use RefreshDatabase;

    // *** districts.index ***

    /** @test */
    public function guest_user_cannot_index_districts()
    {
        $this->json('GET', route('api.districts.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_districts()
    {
        $this->signIn();

        $this->json('GET', route('api.districts.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_districts()
    {
        $this->signInWithPermission('districts.index');

        $district1 = factory(District::class)->create();
        $district2 = factory(District::class)->create();

        $this->json('GET', route('api.districts.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $district1->uuid,
                        'code' => $district1->code,
                        'name' => $district1->name,
                    ],
                    [
                        'uuid' => $district2->uuid,
                        'code' => $district2->code,
                        'name' => $district2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/districts?page=1',
                    'last' => 'http://localhost/api/districts?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/districts',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_districts_by_code()
    {
        $this->signInWithPermission('districts.index');

        $district_a1 = factory(District::class)->create(['code' => 'a-001']);
        $district_a2 = factory(District::class)->create(['code' => 'a-002']);
        $district_b1 = factory(District::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.districts.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $district_a1->uuid,
                        'code' => $district_a1->code,
                        'name' => $district_a1->name,
                    ],
                    [
                        'uuid' => $district_a2->uuid,
                        'code' => $district_a2->code,
                        'name' => $district_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $district_b1->uuid,
                        'code' => $district_b1->code,
                        'name' => $district_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_districts_by_name()
    {
        $this->signInWithPermission('districts.index');

        $district_a1 = factory(District::class)->create(['name' => 'a-001']);
        $district_a2 = factory(District::class)->create(['name' => 'a-002']);
        $district_b1 = factory(District::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.districts.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $district_a1->uuid,
                        'code' => $district_a1->code,
                        'name' => $district_a1->name,
                    ],
                    [
                        'uuid' => $district_a2->uuid,
                        'code' => $district_a2->code,
                        'name' => $district_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $district_b1->uuid,
                        'code' => $district_b1->code,
                        'name' => $district_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_districts_by_code_or_name()
    {
        $this->signInWithPermission('districts.index');

        $district_a1 = factory(District::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $district_a2 = factory(District::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $district_b1 = factory(District::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $district_b2 = factory(District::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.districts.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $district_a1->uuid,
                        'code' => $district_a1->code,
                        'name' => $district_a1->name,
                    ],
                    [
                        'uuid' => $district_a2->uuid,
                        'code' => $district_a2->code,
                        'name' => $district_a2->name,
                    ],
                    [
                        'uuid' => $district_b2->uuid,
                        'code' => $district_b2->code,
                        'name' => $district_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $district_b1->uuid,
                        'code' => $district_b1->code,
                        'name' => $district_b1->name,
                    ]
                ]
            ]);
    }

    // *** districts.show ***

    /** @test */
    public function guest_user_cannot_view_a_district()
    {
        $district1 = factory(District::class)->create();

        $this->json('GET', route('api.districts.show', $district1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_district()
    {
        $this->signIn();

        $district1 = factory(District::class)->create();

        $this->json('GET', route('api.districts.show', $district1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_district()
    {
        $this->signInWithPermission('districts.show');

        $district1 = factory(District::class)->create();

        $this->json('GET', route('api.districts.show', $district1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $district1->uuid,
                    'code' => $district1->code,
                    'name' => $district1->name,
                ],
            ]);
    }

    // *** districts.store ***

    /** @test */
    public function guest_user_cannot_create_a_district()
    {
        $district1 = factory(District::class)->make();

        $this->json('POST', route('api.districts.store'), $district1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_district()
    {
        $this->signIn();

        $district1 = factory(District::class)->make();

        $this->json('POST', route('api.districts.store'), $district1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_district_requires_required_fields()
    {
        $this->signInWithPermission('districts.create');

        $this->json('POST', route('api.districts.store'))
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

    /**  @test */
    public function create_a_district_requires_valid_fields()
    {
        $this->signInWithPermission('districts.create');

        $district = factory(District::class)->make();

        $this->json('POST', route('api.districts.store'))
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
    public function authorized_user_can_create_a_district()
    {
        $this->signInWithPermission('districts.create');

        $district = factory(District::class)->make();

        $this->json('POST', route('api.districts.store'),
            [
                'code' => $district->code,
                'name' => $district->name,
                'province_id' => $district->province_id,
            ])
            ->assertStatus(201);
    }

    // *** districts.update ***

    /** @test */
    public function guest_user_cannot_update_a_district()
    {
        $district1 = factory(District::class)->create();

        $district_updated = factory(District::class)->make();

        $this->json('PATCH', route('api.districts.update', $district1->uuid),
            [
                'code' => $district_updated->code,
                'name' => $district_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_district()
    {
        $this->signIn();

        $district1 = factory(District::class)->create();

        $district_updated = factory(District::class)->make();

        $this->json('PATCH', route('api.districts.update', $district1->uuid),
            [
                'code' => $district_updated->code,
                'name' => $district_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_district_requires_valid_fields()
    {
        $this->signInWithPermission('districts.update');

        $district1 = factory(District::class)->create();

        $this->json('PATCH', route('api.districts.update', $district1->uuid))
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
    public function authorized_user_can_update_a_district()
    {
        $this->signInWithPermission('districts.update');

        $district1 = factory(District::class)->create();

        $district_updated = factory(District::class)->make();

        $this->json('PATCH', route('api.districts.update', $district1->uuid),
            [
                'code' => $district_updated->code,
                'name' => $district_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('districts', [
            'id' => $district1->id,
            'uuid' => $district1->uuid,
            'code' => $district_updated->code,
            'name' => $district_updated->name,
        ]);
    }

    // *** districts.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_district()
    {
        $district1 = factory(District::class)->create();

        $this->json('DELETE', route('api.districts.destroy', $district1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_district()
    {
        $this->signIn();

        $district1 = factory(District::class)->create();

        $this->json('DELETE', route('api.districts.destroy', $district1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_district()
    {
        $this->signInWithPermission('districts.delete');

        $district1 = factory(District::class)->create();

        $this->json('DELETE', route('api.districts.destroy', $district1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('districts', [
            'id' => $district1->id,
        ]);
    }
}
