<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Doc;

class DocApiTest extends TestCase
{
    use RefreshDatabase;

    // *** docs.index ***

    /** @test */
    public function guest_user_cannot_index_docs()
    {
        $this->json('GET', route('api.docs.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_docs()
    {
        $this->signIn();

        $this->json('GET', route('api.docs.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_docs()
    {
        $this->signInWithPermission('docs.index');

        $doc1 = factory(Doc::class)->create();
        $doc2 = factory(Doc::class)->create();

        $user = auth()->user();

        $this->json('GET', route('api.docs.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc1->uuid,
                        'code' => $doc1->code,
                        'name' => $doc1->name,
                    ],
                    [
                        'uuid' => $doc2->uuid,
                        'code' => $doc2->code,
                        'name' => $doc2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/docs?page=1',
                    'last' => 'http://localhost/api/docs?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/docs',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_docs_by_code()
    {
        $this->signInWithPermission('docs.index');

        $doc_a1 = factory(Doc::class)->create(['code' => 'a-001']);
        $doc_a2 = factory(Doc::class)->create(['code' => 'a-002']);
        $doc_b1 = factory(Doc::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.docs.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc_a1->uuid,
                        'code' => $doc_a1->code,
                        'name' => $doc_a1->name,
                    ],
                    [
                        'uuid' => $doc_a2->uuid,
                        'code' => $doc_a2->code,
                        'name' => $doc_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $doc_b1->uuid,
                        'code' => $doc_b1->code,
                        'name' => $doc_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_docs_by_name()
    {
        $this->signInWithPermission('docs.index');

        $doc_a1 = factory(Doc::class)->create(['name' => 'a-001']);
        $doc_a2 = factory(Doc::class)->create(['name' => 'a-002']);
        $doc_b1 = factory(Doc::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.docs.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc_a1->uuid,
                        'code' => $doc_a1->code,
                        'name' => $doc_a1->name,
                    ],
                    [
                        'uuid' => $doc_a2->uuid,
                        'code' => $doc_a2->code,
                        'name' => $doc_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $doc_b1->uuid,
                        'code' => $doc_b1->code,
                        'name' => $doc_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_docs_by_code_or_name()
    {
        $this->signInWithPermission('docs.index');

        $doc_a1 = factory(Doc::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $doc_a2 = factory(Doc::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $doc_b1 = factory(Doc::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $doc_b2 = factory(Doc::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.docs.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc_a1->uuid,
                        'code' => $doc_a1->code,
                        'name' => $doc_a1->name,
                    ],
                    [
                        'uuid' => $doc_a2->uuid,
                        'code' => $doc_a2->code,
                        'name' => $doc_a2->name,
                    ],
                    [
                        'uuid' => $doc_b2->uuid,
                        'code' => $doc_b2->code,
                        'name' => $doc_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $doc_b1->uuid,
                        'code' => $doc_b1->code,
                        'name' => $doc_b1->name,
                    ]
                ]
            ]);
    }

    // *** docs.show ***

    /** @test */
    public function guest_user_cannot_view_an_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $this->json('GET', route('api.docs.show', $doc1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_an_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $this->json('GET', route('api.docs.show', $doc1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_an_doc()
    {
        $this->signInWithPermission('docs.show');

        $doc1 = factory(Doc::class)->create();

        $this->json('GET', route('api.docs.show', $doc1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $doc1->uuid,
                    'code' => $doc1->code,
                    'name' => $doc1->name,
                ],
            ]);
    }

    // *** docs.store ***

    /** @test */
    public function guest_user_cannot_create_an_doc()
    {
        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store'), $doc1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_an_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store'), $doc1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_an_doc_requires_valid_fields()
    {
        $this->signInWithPermission('docs.create');

        $this->json('POST', route('api.docs.store'))
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
    public function authorized_user_can_create_an_doc()
    {
        $this->signInWithPermission('docs.create');

        $doc1 = factory(Doc::class)->make();

        $this->json('POST', route('api.docs.store'),
            [
                'code' => $doc1->code,
                'name' => $doc1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('docs', [
            'code' => $doc1->code,
            'name' => $doc1->name,
        ]);
    }

    // *** docs.update ***

    /** @test */
    public function guest_user_cannot_update_an_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', $doc1->uuid),
            [
                'code' => $doc_updated->code,
                'name' => $doc_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_an_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', $doc1->uuid),
            [
                'code' => $doc_updated->code,
                'name' => $doc_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_an_doc_requires_valid_fields()
    {
        $this->signInWithPermission('docs.update');

        $doc1 = factory(Doc::class)->create();

        $this->json('PATCH', route('api.docs.update', $doc1->uuid))
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
    public function authorized_user_can_update_an_doc()
    {
        $this->signInWithPermission('docs.update');

        $doc1 = factory(Doc::class)->create();

        $doc_updated = factory(Doc::class)->make();

        $this->json('PATCH', route('api.docs.update', $doc1->uuid),
            [
                'code' => $doc_updated->code,
                'name' => $doc_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('docs', [
            'id' => $doc1->id,
            'uuid' => $doc1->uuid,
            'code' => $doc_updated->code,
            'name' => $doc_updated->name,
        ]);
    }

    // *** docs.delete ***

    /** @test */
    public function guest_user_cannot_delete_an_doc()
    {
        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', $doc1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_an_doc()
    {
        $this->signIn();

        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', $doc1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_an_doc()
    {
        $this->signInWithPermission('docs.delete');

        $doc1 = factory(Doc::class)->create();

        $this->json('DELETE', route('api.docs.destroy', $doc1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('docs', [
            'id' => $doc1->id,
        ]);
    }
}
