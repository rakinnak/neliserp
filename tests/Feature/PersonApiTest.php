<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Person;

class PersonApiTest extends TestCase
{
    use RefreshDatabase;

    // *** persons.index ***

    /** @test */
    public function guest_user_cannot_index_persons()
    {
        $this->json('GET', route('api.persons.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_persons()
    {
        $this->signIn();

        $this->json('GET', route('api.persons.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_persons()
    {
        $this->signInWithPermission('persons.index');

        $person1 = factory(Person::class)->create();
        $person2 = factory(Person::class)->create();

        $user = auth()->user();

        $this->json('GET', route('api.persons.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                ],
                'links' => [
                    'first' => 'http://localhost/api/persons?page=1',
                    'last' => 'http://localhost/api/persons?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/persons',
                    'per_page' => 10,
                    'to' => 3,      // +1 for logged user's person
                    'total' => 3,   // +1 for logged user's person
                ],
            ])
            ->assertJsonFragment([
                'uuid' => $person1->uuid,
                'code' => $person1->code,
                'first_name' => $person1->first_name,
                'last_name' => $person1->last_name,
            ])
            ->assertJsonFragment([
                'uuid' => $person2->uuid,
                'code' => $person2->code,
                'first_name' => $person2->first_name,
                'last_name' => $person2->last_name,
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_persons_by_code()
    {
        $this->signInWithPermission('persons.index');

        $person_a1 = factory(Person::class)->create(['code' => 'a-001']);
        $person_a2 = factory(Person::class)->create(['code' => 'a-002']);
        $person_b1 = factory(Person::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.persons.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $person_a1->uuid,
                        'code' => $person_a1->code,
                        'first_name' => $person_a1->first_name,
                        'last_name' => $person_a1->last_name,
                    ],
                    [
                        'uuid' => $person_a2->uuid,
                        'code' => $person_a2->code,
                        'first_name' => $person_a2->first_name,
                        'last_name' => $person_a2->last_name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $person_b1->uuid,
                        'code' => $person_b1->code,
                        'first_name' => $person_b1->first_name,
                        'last_name' => $person_b1->last_name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_persons_by_name()
    {
        $this->signInWithPermission('persons.index');

        $person_a1 = factory(Person::class)->create(['first_name' => 'a-001']);
        $person_a2 = factory(Person::class)->create(['first_name' => 'a-002']);
        $person_b1 = factory(Person::class)->create(['first_name' => 'b-001']);

        $this->json('GET', route('api.persons.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $person_a1->uuid,
                        'code' => $person_a1->code,
                        'first_name' => $person_a1->first_name,
                        'last_name' => $person_a1->last_name,
                    ],
                    [
                        'uuid' => $person_a2->uuid,
                        'code' => $person_a2->code,
                        'first_name' => $person_a2->first_name,
                        'last_name' => $person_a2->last_name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $person_b1->uuid,
                        'code' => $person_b1->code,
                        'first_name' => $person_b1->first_name,
                        'last_name' => $person_b1->last_name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_persons_by_code_or_name()
    {
        $this->signInWithPermission('persons.index');

        $person_a1 = factory(Person::class)->create(['code' => 'aaa-001', 'first_name' => 'c-001']);
        $person_a2 = factory(Person::class)->create(['code' => 'aaa-002', 'first_name' => 'c-002']);
        $person_b1 = factory(Person::class)->create(['code' => 'b-001', 'first_name' => 'c-003']);
        $person_b2 = factory(Person::class)->create(['code' => 'b-002', 'first_name' => 'aaa-004']);

        $this->json('GET', route('api.persons.index') . '?q=aaa')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $person_a1->uuid,
                        'code' => $person_a1->code,
                        'first_name' => $person_a1->first_name,
                        'last_name' => $person_a1->last_name,
                    ],
                    [
                        'uuid' => $person_a2->uuid,
                        'code' => $person_a2->code,
                        'first_name' => $person_a2->first_name,
                        'last_name' => $person_a2->last_name,
                    ],
                    [
                        'uuid' => $person_b2->uuid,
                        'code' => $person_b2->code,
                        'first_name' => $person_b2->first_name,
                        'last_name' => $person_b2->last_name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $person_b1->uuid,
                        'code' => $person_b1->code,
                        'first_name' => $person_b1->first_name,
                        'last_name' => $person_b1->last_name,
                    ]
                ]
            ]);
    }

    // *** persons.show ***

    /** @test */
    public function guest_user_cannot_view_a_person()
    {
        $person1 = factory(Person::class)->create();

        $this->json('GET', route('api.persons.show', $person1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_person()
    {
        $this->signIn();

        $person1 = factory(Person::class)->create();

        $this->json('GET', route('api.persons.show', $person1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_person()
    {
        $this->signInWithPermission('persons.show');

        $person1 = factory(Person::class)->create();

        $this->json('GET', route('api.persons.show', $person1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $person1->uuid,
                    'code' => $person1->code,
                    'first_name' => $person1->first_name,
                    'last_name' => $person1->last_name,
                ],
            ]);
    }

    // *** persons.store ***

    /** @test */
    public function guest_user_cannot_create_a_person()
    {
        $person1 = factory(Person::class)->make();

        $this->json('POST', route('api.persons.store'), $person1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_person()
    {
        $this->signIn();

        $person1 = factory(Person::class)->make();

        $this->json('POST', route('api.persons.store'), $person1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_person_requires_valid_fields()
    {
        $this->signInWithPermission('persons.create');

        $this->json('POST', route('api.persons.store'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_create_a_person()
    {
        $this->signInWithPermission('persons.create');

        $person1 = factory(Person::class)->make();

        $this->json('POST', route('api.persons.store'),
            [
                'code' => $person1->code,
                'first_name' => $person1->first_name,
                'last_name' => $person1->last_name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('persons', [
            'code' => $person1->code,
            'first_name' => $person1->first_name,
            'last_name' => $person1->last_name,
        ]);
    }

    // *** persons.update ***

    /** @test */
    public function guest_user_cannot_update_a_person()
    {
        $person1 = factory(Person::class)->create();

        $person_updated = factory(Person::class)->make();

        $this->json('PATCH', route('api.persons.update', $person1->uuid),
            [
                'code' => $person_updated->code,
                'first_name' => $person_updated->first_name,
                'last_name' => $person_updated->last_name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_person()
    {
        $this->signIn();

        $person1 = factory(Person::class)->create();

        $person_updated = factory(Person::class)->make();

        $this->json('PATCH', route('api.persons.update', $person1->uuid),
            [
                'code' => $person_updated->code,
                'first_name' => $person_updated->first_name,
                'last_name' => $person_updated->last_name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_person_requires_valid_fields()
    {
        $this->signInWithPermission('persons.update');

        $person1 = factory(Person::class)->create();

        $this->json('PATCH', route('api.persons.update', $person1->uuid))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_update_a_person()
    {
        $this->signInWithPermission('persons.update');

        $person1 = factory(Person::class)->create();

        $person_updated = factory(Person::class)->make();

        $this->json('PATCH', route('api.persons.update', $person1->uuid),
            [
                'code' => $person_updated->code,
                'first_name' => $person_updated->first_name,
                'last_name' => $person_updated->last_name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('persons', [
            'id' => $person1->id,
            'uuid' => $person1->uuid,
            'code' => $person_updated->code,
            'first_name' => $person_updated->first_name,
            'last_name' => $person_updated->last_name,
        ]);
    }

    // *** persons.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_person()
    {
        $person1 = factory(Person::class)->create();

        $this->json('DELETE', route('api.persons.destroy', $person1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_person()
    {
        $this->signIn();

        $person1 = factory(Person::class)->create();

        $this->json('DELETE', route('api.persons.destroy', $person1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_person()
    {
        $this->signInWithPermission('persons.delete');

        $person1 = factory(Person::class)->create();

        $this->json('DELETE', route('api.persons.destroy', $person1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('persons', [
            'id' => $person1->id,
        ]);
    }
}
