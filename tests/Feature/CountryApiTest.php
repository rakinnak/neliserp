<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Country;

class CountryApiTest extends TestCase
{
    use RefreshDatabase;

    // *** countries.index ***

    /** @test */
    public function guest_user_cannot_index_countries()
    {
        $this->json('GET', route('api.countries.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_countries()
    {
        $this->signIn();

        $this->json('GET', route('api.countries.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_countries()
    {
        $this->signInWithPermission('countries.index');

        $country1 = factory(Country::class)->create();
        $country2 = factory(Country::class)->create();

        $this->json('GET', route('api.countries.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $country1->uuid,
                        'code' => $country1->code,
                        'name' => $country1->name,
                    ],
                    [
                        'uuid' => $country2->uuid,
                        'code' => $country2->code,
                        'name' => $country2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/countries?page=1',
                    'last' => 'http://localhost/api/countries?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/countries',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_countries_by_code()
    {
        $this->signInWithPermission('countries.index');

        $country_a1 = factory(Country::class)->create(['code' => 'a-001']);
        $country_a2 = factory(Country::class)->create(['code' => 'a-002']);
        $country_b1 = factory(Country::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.countries.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $country_a1->uuid,
                        'code' => $country_a1->code,
                        'name' => $country_a1->name,
                    ],
                    [
                        'uuid' => $country_a2->uuid,
                        'code' => $country_a2->code,
                        'name' => $country_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $country_b1->uuid,
                        'code' => $country_b1->code,
                        'name' => $country_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_countries_by_name()
    {
        $this->signInWithPermission('countries.index');

        $country_a1 = factory(Country::class)->create(['name' => 'a-001']);
        $country_a2 = factory(Country::class)->create(['name' => 'a-002']);
        $country_b1 = factory(Country::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.countries.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $country_a1->uuid,
                        'code' => $country_a1->code,
                        'name' => $country_a1->name,
                    ],
                    [
                        'uuid' => $country_a2->uuid,
                        'code' => $country_a2->code,
                        'name' => $country_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $country_b1->uuid,
                        'code' => $country_b1->code,
                        'name' => $country_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_countries_by_code_or_name()
    {
        $this->signInWithPermission('countries.index');

        $country_a1 = factory(Country::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $country_a2 = factory(Country::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $country_b1 = factory(Country::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $country_b2 = factory(Country::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.countries.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $country_a1->uuid,
                        'code' => $country_a1->code,
                        'name' => $country_a1->name,
                    ],
                    [
                        'uuid' => $country_a2->uuid,
                        'code' => $country_a2->code,
                        'name' => $country_a2->name,
                    ],
                    [
                        'uuid' => $country_b2->uuid,
                        'code' => $country_b2->code,
                        'name' => $country_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $country_b1->uuid,
                        'code' => $country_b1->code,
                        'name' => $country_b1->name,
                    ]
                ]
            ]);
    }

    // *** countries.show ***

    /** @test */
    public function guest_user_cannot_view_a_country()
    {
        $country1 = factory(Country::class)->create();

        $this->json('GET', route('api.countries.show', $country1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_country()
    {
        $this->signIn();

        $country1 = factory(Country::class)->create();

        $this->json('GET', route('api.countries.show', $country1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_country()
    {
        $this->signInWithPermission('countries.show');

        $country1 = factory(Country::class)->create();

        $this->json('GET', route('api.countries.show', $country1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $country1->uuid,
                    'code' => $country1->code,
                    'name' => $country1->name,
                ],
            ]);
    }

    // *** countries.store ***

    /** @test */
    public function guest_user_cannot_create_a_country()
    {
        $country1 = factory(Country::class)->make();

        $this->json('POST', route('api.countries.store'), $country1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_country()
    {
        $this->signIn();

        $country1 = factory(Country::class)->make();

        $this->json('POST', route('api.countries.store'), $country1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_country_requires_required_fields()
    {
        $this->signInWithPermission('countries.create');

        $this->json('POST', route('api.countries.store'))
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
    public function create_a_country_requires_valid_fields()
    {
        $this->signInWithPermission('countries.create');

        $country = factory(Country::class)->make();

        $this->json('POST', route('api.countries.store'))
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
    public function authorized_user_can_create_a_country()
    {
        $this->signInWithPermission('countries.create');

        $country = factory(Country::class)->make();

        $this->json('POST', route('api.countries.store'),
            [
                'code' => $country->code,
                'name' => $country->name,
            ])
            ->assertStatus(201);
    }

    // *** countries.update ***

    /** @test */
    public function guest_user_cannot_update_a_country()
    {
        $country1 = factory(Country::class)->create();

        $country_updated = factory(Country::class)->make();

        $this->json('PATCH', route('api.countries.update', $country1->uuid),
            [
                'code' => $country_updated->code,
                'name' => $country_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_country()
    {
        $this->signIn();

        $country1 = factory(Country::class)->create();

        $country_updated = factory(Country::class)->make();

        $this->json('PATCH', route('api.countries.update', $country1->uuid),
            [
                'code' => $country_updated->code,
                'name' => $country_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_country_requires_valid_fields()
    {
        $this->signInWithPermission('countries.update');

        $country1 = factory(Country::class)->create();

        $this->json('PATCH', route('api.countries.update', $country1->uuid))
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
    public function authorized_user_can_update_a_country()
    {
        $this->signInWithPermission('countries.update');

        $country1 = factory(Country::class)->create();

        $country_updated = factory(Country::class)->make();

        $this->json('PATCH', route('api.countries.update', $country1->uuid),
            [
                'code' => $country_updated->code,
                'name' => $country_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('countries', [
            'id' => $country1->id,
            'uuid' => $country1->uuid,
            'code' => $country_updated->code,
            'name' => $country_updated->name,
        ]);
    }

    // *** countries.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_country()
    {
        $country1 = factory(Country::class)->create();

        $this->json('DELETE', route('api.countries.destroy', $country1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_country()
    {
        $this->signIn();

        $country1 = factory(Country::class)->create();

        $this->json('DELETE', route('api.countries.destroy', $country1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_country()
    {
        $this->signInWithPermission('countries.delete');

        $country1 = factory(Country::class)->create();

        $this->json('DELETE', route('api.countries.destroy', $country1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('countries', [
            'id' => $country1->id,
        ]);
    }
}
