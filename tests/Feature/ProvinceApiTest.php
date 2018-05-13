<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Province;

class ProvinceApiTest extends TestCase
{
    use RefreshDatabase;

    // *** provinces.index ***

    /** @test */
    public function guest_user_cannot_index_provinces()
    {
        $this->json('GET', route('api.provinces.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_provinces()
    {
        $this->signIn();

        $this->json('GET', route('api.provinces.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_provinces()
    {
        $this->signInWithPermission('provinces.index');

        $province1 = factory(Province::class)->create();
        $province2 = factory(Province::class)->create();

        $this->json('GET', route('api.provinces.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $province1->uuid,
                        'code' => $province1->code,
                        'name' => $province1->name,
                    ],
                    [
                        'uuid' => $province2->uuid,
                        'code' => $province2->code,
                        'name' => $province2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/provinces?page=1',
                    'last' => 'http://localhost/api/provinces?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/provinces',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_provinces_by_code()
    {
        $this->signInWithPermission('provinces.index');

        $province_a1 = factory(Province::class)->create(['code' => 'a-001']);
        $province_a2 = factory(Province::class)->create(['code' => 'a-002']);
        $province_b1 = factory(Province::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.provinces.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $province_a1->uuid,
                        'code' => $province_a1->code,
                        'name' => $province_a1->name,
                    ],
                    [
                        'uuid' => $province_a2->uuid,
                        'code' => $province_a2->code,
                        'name' => $province_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $province_b1->uuid,
                        'code' => $province_b1->code,
                        'name' => $province_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_provinces_by_name()
    {
        $this->signInWithPermission('provinces.index');

        $province_a1 = factory(Province::class)->create(['name' => 'a-001']);
        $province_a2 = factory(Province::class)->create(['name' => 'a-002']);
        $province_b1 = factory(Province::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.provinces.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $province_a1->uuid,
                        'code' => $province_a1->code,
                        'name' => $province_a1->name,
                    ],
                    [
                        'uuid' => $province_a2->uuid,
                        'code' => $province_a2->code,
                        'name' => $province_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $province_b1->uuid,
                        'code' => $province_b1->code,
                        'name' => $province_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_provinces_by_code_or_name()
    {
        $this->signInWithPermission('provinces.index');

        $province_a1 = factory(Province::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $province_a2 = factory(Province::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $province_b1 = factory(Province::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $province_b2 = factory(Province::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.provinces.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $province_a1->uuid,
                        'code' => $province_a1->code,
                        'name' => $province_a1->name,
                    ],
                    [
                        'uuid' => $province_a2->uuid,
                        'code' => $province_a2->code,
                        'name' => $province_a2->name,
                    ],
                    [
                        'uuid' => $province_b2->uuid,
                        'code' => $province_b2->code,
                        'name' => $province_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $province_b1->uuid,
                        'code' => $province_b1->code,
                        'name' => $province_b1->name,
                    ]
                ]
            ]);
    }

    // *** provinces.show ***

    /** @test */
    public function guest_user_cannot_view_a_province()
    {
        $province1 = factory(Province::class)->create();

        $this->json('GET', route('api.provinces.show', $province1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_province()
    {
        $this->signIn();

        $province1 = factory(Province::class)->create();

        $this->json('GET', route('api.provinces.show', $province1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_province()
    {
        $this->signInWithPermission('provinces.show');

        $province1 = factory(Province::class)->create();

        $this->json('GET', route('api.provinces.show', $province1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $province1->uuid,
                    'code' => $province1->code,
                    'name' => $province1->name,
                ],
            ]);
    }

    // *** provinces.store ***

    /** @test */
    public function guest_user_cannot_create_a_province()
    {
        $province1 = factory(Province::class)->make();

        $this->json('POST', route('api.provinces.store'), $province1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_province()
    {
        $this->signIn();

        $province1 = factory(Province::class)->make();

        $this->json('POST', route('api.provinces.store'), $province1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_province_requires_required_fields()
    {
        $this->signInWithPermission('provinces.create');

        $this->json('POST', route('api.provinces.store'))
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
    public function create_a_province_requires_valid_fields()
    {
        $this->signInWithPermission('provinces.create');

        $province = factory(Province::class)->make();

        $this->json('POST', route('api.provinces.store'))
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
    public function authorized_user_can_create_a_province()
    {
        $this->signInWithPermission('provinces.create');

        $province = factory(Province::class)->make();

        $this->json('POST', route('api.provinces.store'),
            [
                'code' => $province->code,
                'name' => $province->name,
                'country_id' => $province->country_id,
            ])
            ->assertStatus(201);
    }

    // *** provinces.update ***

    /** @test */
    public function guest_user_cannot_update_a_province()
    {
        $province1 = factory(Province::class)->create();

        $province_updated = factory(Province::class)->make();

        $this->json('PATCH', route('api.provinces.update', $province1->uuid),
            [
                'code' => $province_updated->code,
                'name' => $province_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_province()
    {
        $this->signIn();

        $province1 = factory(Province::class)->create();

        $province_updated = factory(Province::class)->make();

        $this->json('PATCH', route('api.provinces.update', $province1->uuid),
            [
                'code' => $province_updated->code,
                'name' => $province_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_province_requires_valid_fields()
    {
        $this->signInWithPermission('provinces.update');

        $province1 = factory(Province::class)->create();

        $this->json('PATCH', route('api.provinces.update', $province1->uuid))
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
    public function authorized_user_can_update_a_province()
    {
        $this->signInWithPermission('provinces.update');

        $province1 = factory(Province::class)->create();

        $province_updated = factory(Province::class)->make();

        $this->json('PATCH', route('api.provinces.update', $province1->uuid),
            [
                'code' => $province_updated->code,
                'name' => $province_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('provinces', [
            'id' => $province1->id,
            'uuid' => $province1->uuid,
            'code' => $province_updated->code,
            'name' => $province_updated->name,
        ]);
    }

    // *** provinces.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_province()
    {
        $province1 = factory(Province::class)->create();

        $this->json('DELETE', route('api.provinces.destroy', $province1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_province()
    {
        $this->signIn();

        $province1 = factory(Province::class)->create();

        $this->json('DELETE', route('api.provinces.destroy', $province1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_province()
    {
        $this->signInWithPermission('provinces.delete');

        $province1 = factory(Province::class)->create();

        $this->json('DELETE', route('api.provinces.destroy', $province1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('provinces', [
            'id' => $province1->id,
        ]);
    }
}
