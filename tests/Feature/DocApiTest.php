<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Doc;

class DocApiTest extends TestCase
{
    use RefreshDatabase;

    protected $type;

    public function setUp()
    {
        parent::setUp();

        $this->type = 'docs';
    }


    // *** docs.index ***

    /** @test */
    public function guest_user_cannot_index_docs()
    {
        $this->json('GET', route('api.docs.index', $this->type))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_docs()
    {
        $this->signIn();

        $this->json('GET', route('api.docs.index', $this->type))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_docs()
    {
        $this->signInWithPermission('docs.index');

        $doc1 = factory(Doc::class)->create([
            'type' => $this->type,
        ]);
        $doc2 = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $user = auth()->user();

        $this->json('GET', route('api.docs.index', $this->type))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc1->uuid,
                        'name' => $doc1->name,
                        'type' => $this->type,
                        'company_uuid' => $doc1->company_uuid,
                        'company_code' => $doc1->company_code,
                        'company_name' => $doc1->company_name,
                        'issued_at' => $doc1->issued_at,
                    ],
                    [
                        'uuid' => $doc2->uuid,
                        'name' => $doc2->name,
                        'type' => $this->type,
                        'company_uuid' => $doc2->company_uuid,
                        'company_code' => $doc2->company_code,
                        'company_name' => $doc2->company_name,
                        'issued_at' => $doc2->issued_at,
                    ]
                ],
                'links' => [
                    'first' => "http://localhost/api/docs/{$this->type}?page=1",
                    'last' => "http://localhost/api/docs/{$this->type}?page=1",
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => "http://localhost/api/docs/{$this->type}",
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_docs_by_name()
    {
        $this->signInWithPermission('docs.index');

        $doc_a1 = factory(Doc::class)->create([
            'name' => 'a-001',
            'type' => $this->type,
        ]);

        $doc_a2 = factory(Doc::class)->create([
            'name' => 'a-002',
            'type' => $this->type,
        ]);

        $doc_b1 = factory(Doc::class)->create([
            'name' => 'b-001',
            'type' => $this->type,
        ]);

        $this->json('GET', route('api.docs.index', $this->type) . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc_a1->uuid,
                        'name' => $doc_a1->name,
                        'type' => $this->type,
                        'company_uuid' => $doc_a1->company_uuid,
                        'company_code' => $doc_a1->company_code,
                        'company_name' => $doc_a1->company_name,
                        'issued_at' => $doc_a1->issued_at,
                    ],
                    [
                        'uuid' => $doc_a2->uuid,
                        'name' => $doc_a2->name,
                        'type' => $this->type,
                        'company_uuid' => $doc_a2->company_uuid,
                        'company_code' => $doc_a2->company_code,
                        'company_name' => $doc_a2->company_name,
                        'issued_at' => $doc_a2->issued_at,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $doc_b1->uuid,
                        'name' => $doc_b1->name,
                        'type' => $this->type,
                        'company_uuid' => $doc_b1->company_uuid,
                        'company_code' => $doc_b1->company_code,
                        'company_name' => $doc_b1->company_name,
                        'issued_at' => $doc_b1->issued_at,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_index_only_specified_type()
    {
        $this->signInWithPermission('docs.index');

        $doc1 = factory(Doc::class)->create([
            'type' => $this->type . '-another',
        ]);

        $doc2 = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $user = auth()->user();

        $this->json('GET', route('api.docs.index', $this->type))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc2->uuid,
                        'name' => $doc2->name,
                        'type' => $this->type,
                        'company_uuid' => $doc2->company_uuid,
                        'company_code' => $doc2->company_code,
                        'company_name' => $doc2->company_name,
                        'issued_at' => $doc2->issued_at,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $doc1->uuid,
                        'name' => $doc1->name,
                        'type' => $this->type . '-another',
                        'company_uuid' => $doc1->company_uuid,
                        'company_code' => $doc1->company_code,
                        'company_name' => $doc1->company_name,
                        'issued_at' => $doc1->issued_at,
                    ]
                ]
            ]);
    }

    // *** docs.show ***

    /** @test */
    public function guest_user_cannot_view_a_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $this->json('GET', route('api.docs.show', [$this->type, $doc1->uuid]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $this->json('GET', route('api.docs.show', [$this->type, $doc1->uuid]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_doc()
    {
        $this->signInWithPermission('docs.show');

        $doc1 = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $this->json('GET', route('api.docs.show', [$this->type, $doc1->uuid]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $doc1->uuid,
                    'name' => $doc1->name,
                    'type' => $this->type,
                    'company_uuid' => $doc1->company_uuid,
                    'company_code' => $doc1->company_code,
                    'company_name' => $doc1->company_name,
                    'issued_at' => $doc1->issued_at,
                ],
            ]);
    }

    /** @test */
    public function view_a_doc_within_another_type_url_return_not_found()
    {
        $this->signInWithPermission('docs.show');

        $doc1 = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $this->json('GET', route('api.docs.show', [$this->type . '-another', $doc1->uuid]))
            ->assertStatus(404);
    }

    // *** docs.store ***

    /** @test */
    public function guest_user_cannot_create_a_doc()
    {
        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store', $this->type), $doc1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store', $this->type), $doc1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_doc_requires_required_fields()
    {
        $this->signInWithPermission('docs.create');

        $this->json('POST', route('api.docs.store', $this->type))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                    'company_code' => [
                        'The company code field is required.'
                    ],
                    'issued_at' => [
                        'The issued at field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function create_a_doc_requires_valid_fields()
    {
        $this->signInWithPermission('docs.create');

        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store', $this->type),
            [
                'name' => $doc1->name,
                'company_code' => 9999,
                'issued_at' => 1234,
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'company_code' => [
                        'The selected company code is invalid.',
                    ],
                    'issued_at' => [
                        'The issued at is not a valid date.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_create_a_doc()
    {
        $this->signInWithPermission('docs.create');

        $user = auth()->user();

        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store', $this->type),
            [
                'name' => $doc1->name,
                'company_code' => $doc1->company_code,
                'issued_at' => $doc1->issued_at,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('docs', [
            'name' => $doc1->name,
            'type' => $this->type,
            'company_id' => $doc1->company_id,
            'company_uuid' => $doc1->company_uuid,
            'company_code' => $doc1->company_code,
            'company_name' => $doc1->company_name,
            'user_id' => $user->id,
            'user_uuid' => $user->uuid,
            'user_username' => $user->username,
            'issued_at' => $doc1->issued_at . ' 00:00:00',
        ]);
    }

    // *** docs.update ***

    /** @test */
    public function guest_user_cannot_update_a_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', [$this->type, $doc1->uuid]),
            [
                'name' => $doc_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', [$this->type, $doc1->uuid]),
            [
                'name' => $doc_updated->name,
                'company_code' => $doc_updated->company_code,
                'issued_at' => $doc_updated->issued_at,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_doc_requires_required_fields()
    {
        $this->signInWithPermission('docs.update');

        $doc1 = factory(Doc::class)->create();

        $this->json('PATCH', route('api.docs.update', [$this->type, $doc1->uuid]))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                    'company_code' => [
                        'The company code field is required.'
                    ],
                    'issued_at' => [
                        'The issued at field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_doc_requires_valid_fields()
    {
        $this->signInWithPermission('docs.update');

        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', [$this->type, $doc1->uuid]),
            [
                'name' => $doc_updated->name,
                'company_code' => 9999,
                'issued_at' => 1234,
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'company_code' => [
                        'The selected company code is invalid.',
                    ],
                    'issued_at' => [
                        'The issued at is not a valid date.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_update_a_doc()
    {
        $this->signInWithPermission('docs.update');

        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', [$this->type, $doc1->uuid]),
            [
                'name' => $doc_updated->name,
                'company_code' => $doc_updated->company_code,
                'issued_at' => $doc_updated->issued_at,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('docs', [
            'id' => $doc1->id,
            'uuid' => $doc1->uuid,
            'name' => $doc_updated->name,
            'company_id' => $doc_updated->company_id,
            'company_code' => $doc_updated->company_code,
            'company_code' => $doc_updated->company_code,
            'company_name' => $doc_updated->company_name,
        ]);
    }

    // *** docs.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', [$this->type, $doc1->uuid]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', [$this->type, $doc1->uuid]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_doc()
    {
        $this->signInWithPermission('docs.delete');

        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', [$this->type, $doc1->uuid]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('docs', [
            'id' => $doc1->id,
        ]);
    }
}
