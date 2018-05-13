<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\City;

class CityApiTest extends TestCase
{
    use RefreshDatabase;

    // *** cities.index ***

    /** @test */
    public function guest_user_cannot_index_cities()
    {
        $this->json('GET', route('api.cities.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_cities()
    {
        $this->signIn();

        $this->json('GET', route('api.cities.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_cities()
    {
        $this->signInWithPermission('cities.index');

        $city1 = factory(City::class)->create();
        $city2 = factory(City::class)->create();

        $this->json('GET', route('api.cities.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $city1->uuid,
                        'code' => $city1->code,
                        'name' => $city1->name,
                    ],
                    [
                        'uuid' => $city2->uuid,
                        'code' => $city2->code,
                        'name' => $city2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/cities?page=1',
                    'last' => 'http://localhost/api/cities?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/cities',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_cities_by_code()
    {
        $this->signInWithPermission('cities.index');

        $city_a1 = factory(City::class)->create(['code' => 'a-001']);
        $city_a2 = factory(City::class)->create(['code' => 'a-002']);
        $city_b1 = factory(City::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.cities.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $city_a1->uuid,
                        'code' => $city_a1->code,
                        'name' => $city_a1->name,
                    ],
                    [
                        'uuid' => $city_a2->uuid,
                        'code' => $city_a2->code,
                        'name' => $city_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $city_b1->uuid,
                        'code' => $city_b1->code,
                        'name' => $city_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_cities_by_name()
    {
        $this->signInWithPermission('cities.index');

        $city_a1 = factory(City::class)->create(['name' => 'a-001']);
        $city_a2 = factory(City::class)->create(['name' => 'a-002']);
        $city_b1 = factory(City::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.cities.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $city_a1->uuid,
                        'code' => $city_a1->code,
                        'name' => $city_a1->name,
                    ],
                    [
                        'uuid' => $city_a2->uuid,
                        'code' => $city_a2->code,
                        'name' => $city_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $city_b1->uuid,
                        'code' => $city_b1->code,
                        'name' => $city_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_cities_by_code_or_name()
    {
        $this->signInWithPermission('cities.index');

        $city_a1 = factory(City::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $city_a2 = factory(City::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $city_b1 = factory(City::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $city_b2 = factory(City::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.cities.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $city_a1->uuid,
                        'code' => $city_a1->code,
                        'name' => $city_a1->name,
                    ],
                    [
                        'uuid' => $city_a2->uuid,
                        'code' => $city_a2->code,
                        'name' => $city_a2->name,
                    ],
                    [
                        'uuid' => $city_b2->uuid,
                        'code' => $city_b2->code,
                        'name' => $city_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $city_b1->uuid,
                        'code' => $city_b1->code,
                        'name' => $city_b1->name,
                    ]
                ]
            ]);
    }

    // *** cities.show ***

    /** @test */
    public function guest_user_cannot_view_a_city()
    {
        $city1 = factory(City::class)->create();

        $this->json('GET', route('api.cities.show', $city1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_city()
    {
        $this->signIn();

        $city1 = factory(City::class)->create();

        $this->json('GET', route('api.cities.show', $city1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_city()
    {
        $this->signInWithPermission('cities.show');

        $city1 = factory(City::class)->create();

        $this->json('GET', route('api.cities.show', $city1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $city1->uuid,
                    'code' => $city1->code,
                    'name' => $city1->name,
                ],
            ]);
    }

    // *** cities.store ***

    /** @test */
    public function guest_user_cannot_create_a_city()
    {
        $city1 = factory(City::class)->make();

        $this->json('POST', route('api.cities.store'), $city1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_city()
    {
        $this->signIn();

        $city1 = factory(City::class)->make();

        $this->json('POST', route('api.cities.store'), $city1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_city_requires_required_fields()
    {
        $this->signInWithPermission('cities.create');

        $this->json('POST', route('api.cities.store'))
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
    public function create_a_city_requires_valid_fields()
    {
        $this->signInWithPermission('cities.create');

        $city = factory(City::class)->make();

        $this->json('POST', route('api.cities.store'))
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
    public function authorized_user_can_create_a_city()
    {
        $this->signInWithPermission('cities.create');

        $city = factory(City::class)->make();

        $this->json('POST', route('api.cities.store'),
            [
                'code' => $city->code,
                'name' => $city->name,
                'district_id' => $city->district_id,
            ])
            ->assertStatus(201);
    }

    // *** cities.update ***

    /** @test */
    public function guest_user_cannot_update_a_city()
    {
        $city1 = factory(City::class)->create();

        $city_updated = factory(City::class)->make();

        $this->json('PATCH', route('api.cities.update', $city1->uuid),
            [
                'code' => $city_updated->code,
                'name' => $city_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_city()
    {
        $this->signIn();

        $city1 = factory(City::class)->create();

        $city_updated = factory(City::class)->make();

        $this->json('PATCH', route('api.cities.update', $city1->uuid),
            [
                'code' => $city_updated->code,
                'name' => $city_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_city_requires_valid_fields()
    {
        $this->signInWithPermission('cities.update');

        $city1 = factory(City::class)->create();

        $this->json('PATCH', route('api.cities.update', $city1->uuid))
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
    public function authorized_user_can_update_a_city()
    {
        $this->signInWithPermission('cities.update');

        $city1 = factory(City::class)->create();

        $city_updated = factory(City::class)->make();

        $this->json('PATCH', route('api.cities.update', $city1->uuid),
            [
                'code' => $city_updated->code,
                'name' => $city_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('cities', [
            'id' => $city1->id,
            'uuid' => $city1->uuid,
            'code' => $city_updated->code,
            'name' => $city_updated->name,
        ]);
    }

    // *** cities.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_city()
    {
        $city1 = factory(City::class)->create();

        $this->json('DELETE', route('api.cities.destroy', $city1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_city()
    {
        $this->signIn();

        $city1 = factory(City::class)->create();

        $this->json('DELETE', route('api.cities.destroy', $city1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_city()
    {
        $this->signInWithPermission('cities.delete');

        $city1 = factory(City::class)->create();

        $this->json('DELETE', route('api.cities.destroy', $city1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('cities', [
            'id' => $city1->id,
        ]);
    }
}
