<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Doc;
use App\DocItem;

class DocItemApiTest extends TestCase
{
    use RefreshDatabase;

    protected $type;

    public function setUp()
    {
        parent::setUp();

        $this->type = 'docs';
    }


    // *** doc_item.index ***

    /** @test */
    public function guest_user_cannot_index_doc_item()
    {
        $this->json('GET', route('api.doc_item.index', $this->type))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_doc_item()
    {
        $this->signIn();

        $this->json('GET', route('api.doc_item.index', $this->type))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_doc_item()
    {
        $this->signInWithPermission('docs.index');

        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->create([
            'doc_id' => $doc->id,
        ]);
        $doc_item2 = factory(DocItem::class)->create([
            'doc_id' => $doc->id,
        ]);

        $user = auth()->user();

        $this->json('GET', route('api.doc_item.index', $this->type))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $doc_item1->uuid,
                    ],
                    [
                        'uuid' => $doc_item2->uuid,
                    ]
                ],
                'links' => [
                    'first' => "http://localhost/api/doc_item/{$this->type}?page=1",
                    'last' => "http://localhost/api/doc_item/{$this->type}?page=1",
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => "http://localhost/api/doc_item/{$this->type}",
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

//    /** @test */
//    public function authorized_user_can_filter_doc_item_by_doc_name()
//    {
//        $this->signInWithPermission('doc_item.index');
//
//        $doc_item_a1 = factory(DocItem::class)->create([
//            'name' => 'a-001',
//            'type' => $this->type,
//        ]);
//
//        $doc_item_a2 = factory(DocItem::class)->create([
//            'name' => 'a-002',
//            'type' => $this->type,
//        ]);
//
//        $doc_item_b1 = factory(DocItem::class)->create([
//            'name' => 'b-001',
//            'type' => $this->type,
//        ]);
//
//        $this->json('GET', route('api.doc_item.index', $this->type) . '?name=a-00')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $doc_item_a1->uuid,
//                        'name' => $doc_item_a1->name,
//                        'type' => $this->type,
//                        'company_uuid' => $doc_item_a1->company_uuid,
//                        'company_code' => $doc_item_a1->company_code,
//                        'company_name' => $doc_item_a1->company_name,
//                        'issued_at' => $doc_item_a1->issued_at,
//                    ],
//                    [
//                        'uuid' => $doc_item_a2->uuid,
//                        'name' => $doc_item_a2->name,
//                        'type' => $this->type,
//                        'company_uuid' => $doc_item_a2->company_uuid,
//                        'company_code' => $doc_item_a2->company_code,
//                        'company_name' => $doc_item_a2->company_name,
//                        'issued_at' => $doc_item_a2->issued_at,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $doc_item_b1->uuid,
//                        'name' => $doc_item_b1->name,
//                        'type' => $this->type,
//                        'company_uuid' => $doc_item_b1->company_uuid,
//                        'company_code' => $doc_item_b1->company_code,
//                        'company_name' => $doc_item_b1->company_name,
//                        'issued_at' => $doc_item_b1->issued_at,
//                    ]
//                ]
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_index_only_specified_type()
//    {
//        $this->signInWithPermission('doc_item.index');
//
//        $doc_item1 = factory(DocItem::class)->create([
//            'type' => $this->type . '-another',
//        ]);
//
//        $doc_item2 = factory(DocItem::class)->create([
//            'type' => $this->type,
//        ]);
//
//        $user = auth()->user();
//
//        $this->json('GET', route('api.doc_item.index', $this->type))
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $doc_item2->uuid,
//                        'name' => $doc_item2->name,
//                        'type' => $this->type,
//                        'company_uuid' => $doc_item2->company_uuid,
//                        'company_code' => $doc_item2->company_code,
//                        'company_name' => $doc_item2->company_name,
//                        'issued_at' => $doc_item2->issued_at,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $doc_item1->uuid,
//                        'name' => $doc_item1->name,
//                        'type' => $this->type . '-another',
//                        'company_uuid' => $doc_item1->company_uuid,
//                        'company_code' => $doc_item1->company_code,
//                        'company_name' => $doc_item1->company_name,
//                        'issued_at' => $doc_item1->issued_at,
//                    ]
//                ]
//            ]);
//    }

    // *** doc_item.show ***

    /** @test */
    public function guest_user_cannot_view_a_doc_item()
    {
        $doc_item1 = factory(DocItem::class)->create();

        $this->json('GET', route('api.doc_item.show', [$this->type, $doc_item1->uuid]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_doc_item()
    {
        $this->signIn();

        $doc_item1 = factory(DocItem::class)->create();

        $this->json('GET', route('api.doc_item.show', [$this->type, $doc_item1->uuid]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_doc_item()
    {
        $this->signInWithPermission('docs.show');

        $doc_item1 = factory(DocItem::class)->create();

        $this->json('GET', route('api.doc_item.show', [$this->type, $doc_item1->uuid]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $doc_item1->uuid,
                ],
            ]);
    }

    // *** doc_item.store ***

    /** @test */
    public function guest_user_cannot_create_a_doc_item()
    {
        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->make();

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]), $doc_item1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_doc_item()
    {
        $this->signIn();

        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->make();

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]), $doc_item1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_doc_item_requires_required_fields()
    {
        $this->signInWithPermission('doc_item.create');

        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'item_code' => [
                        'The item code field is required.'
                    ],
                    'quantity' => [
                        'The quantity field is required.'
                    ],
                    'unit_price' => [
                        'The unit price field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function create_a_doc_item_requires_valid_fields()
    {
        $this->signInWithPermission('doc_item.create');

        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->make();

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]),
            [
                'ref_uuid' => 'a',
                'line_number' => 'a',
                'item_code' => 'a',
                'quantity' => 'a',
                'unit_price' => 'a',
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'ref_uuid' => [
                        'The selected ref uuid is invalid.',
                    ],
                    'line_number' => [
                        'The line number must be a number.',
                    ],
                    'item_code' => [
                        'The selected item code is invalid.',
                    ],
                    'quantity' => [
                        'The quantity must be a number.',
                    ],
                    'unit_price' => [
                        'The unit price must be a number.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_create_a_doc_item()
    {
        $this->signInWithPermission('docs.create');

        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->make();

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]),
            [
                'line_number' => $doc_item1->line_number,
                'item_code' => $doc_item1->item_code,
                'quantity' => $doc_item1->quantity,
                'unit_price' => $doc_item1->unit_price,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('doc_item', [
            'doc_id' => $doc->id,
            'line_number' => $doc_item1->line_number,
            'ref_id' => null,
            'item_id' => $doc_item1->item_id,
            'item_uuid' => $doc_item1->item_uuid,
            'item_code' => $doc_item1->item_code,
            'item_name' => $doc_item1->item_name,
            'quantity' => $doc_item1->quantity,
            'pending_quantity' => $doc_item1->pending_quantity,
            'unit_price' => $doc_item1->unit_price,
        ]);
    }

    /** @test */
    public function authorized_user_can_create_a_doc_item_with_ref_doc_item()
    {
        $this->signInWithPermission('docs.create');

        // ref
        $ref_doc_item = factory(DocItem::class)->create();

        // new
        $doc = factory(Doc::class)->create([
            'type' => $this->type,
        ]);

        $doc_item1 = factory(DocItem::class)->make();

        $this->json('POST', route('api.doc_item.store', [$this->type, $doc->uuid]),
            [
                'ref_uuid' => $ref_doc_item->uuid,
                'line_number' => $doc_item1->line_number,
                'item_code' => $doc_item1->item_code,
                'quantity' => $doc_item1->quantity,
                'unit_price' => $doc_item1->unit_price,
            ])
            ->assertStatus(201);

        // ref doc_item
        $this->assertDatabaseHas('doc_item', [
            'doc_id' => $ref_doc_item->doc_id,
            'line_number' => $ref_doc_item->line_number,
            'ref_id' => null,
            'item_id' => $ref_doc_item->item_id,
            'item_uuid' => $ref_doc_item->item_uuid,
            'item_code' => $ref_doc_item->item_code,
            'item_name' => $ref_doc_item->item_name,
            'quantity' => $ref_doc_item->quantity,
            'pending_quantity' => $ref_doc_item->pending_quantity - $doc_item1->quantity,
            'unit_price' => $ref_doc_item->unit_price,
        ]);

        // new doc_item
        $this->assertDatabaseHas('doc_item', [
            'doc_id' => $doc->id,
            'line_number' => $doc_item1->line_number,
            'ref_id' => $ref_doc_item->id,
            'item_id' => $doc_item1->item_id,
            'item_uuid' => $doc_item1->item_uuid,
            'item_code' => $doc_item1->item_code,
            'item_name' => $doc_item1->item_name,
            'quantity' => $doc_item1->quantity,
            'pending_quantity' => $doc_item1->pending_quantity,
            'unit_price' => $doc_item1->unit_price,
        ]);
    }

    // *** doc_item.update ***

    /** @test */
    public function guest_user_cannot_update_a_doc_item()
    {
        $doc_item1 = factory(DocItem::class)->create();

        $doc_item_updated = factory(DocItem::class)->make();

        $this->json('PATCH', route('api.doc_item.update', $doc_item1->uuid),
            [
                'line_number' => $doc_item_updated->line_number,
                'item_code' => $doc_item_updated->item_code,
                'quantity' => $doc_item_updated->quantity,
                'unit_price' => $doc_item_updated->unit_price,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_doc_item()
    {
        $this->signIn();

        $doc_item1 = factory(DocItem::class)->create();

        $doc_item_updated = factory(DocItem::class)->make();

        $this->json('PATCH', route('api.doc_item.update', $doc_item1->uuid),
            [
                'line_number' => $doc_item_updated->line_number,
                'item_code' => $doc_item_updated->item_code,
                'quantity' => $doc_item_updated->quantity,
                'unit_price' => $doc_item_updated->unit_price,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_doc_item_requires_required_fields()
    {
        $this->signInWithPermission('docs.update');

        $doc_item1 = factory(DocItem::class)->create();

        $this->json('PATCH', route('api.doc_item.update', $doc_item1->uuid))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'item_code' => [
                        'The item code field is required.'
                    ],
                    'quantity' => [
                        'The quantity field is required.'
                    ],
                    'unit_price' => [
                        'The unit price field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_doc_item_requires_valid_fields()
    {
        $this->signInWithPermission('doc_item.update');

        $doc_item1 = factory(DocItem::class)->create();

        //$doc_item_updated = factory(DocItem::class)->make();

        $this->json('PATCH', route('api.doc_item.update', $doc_item1->uuid),
            [
                'line_number' => 'a',
                'item_code' => 'a',
                'quantity' => 'a',
                'unit_price' => 'a',
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'line_number' => [
                        'The line number must be a number.',
                    ],
                    'item_code' => [
                        'The selected item code is invalid.',
                    ],
                    'quantity' => [
                        'The quantity must be a number.',
                    ],
                    'unit_price' => [
                        'The unit price must be a number.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_update_a_doc_item()
    {
        $this->signInWithPermission('docs.update');

        $doc_item1 = factory(DocItem::class)->create();

        $doc_item_updated = factory(DocItem::class)->make();

        $this->json('PATCH', route('api.doc_item.update', $doc_item1->uuid),
            [
                'line_number' => $doc_item_updated->line_number,
                'item_code' => $doc_item_updated->item_code,
                'quantity' => $doc_item_updated->quantity,
                'unit_price' => $doc_item_updated->unit_price,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('doc_item', [
            'id' => $doc_item1->id,
            'uuid' => $doc_item1->uuid,
            'line_number' => $doc_item_updated->line_number,
            'ref_id' => null,
            'item_id' => $doc_item_updated->item_id,
            'item_uuid' => $doc_item_updated->item_uuid,
            'item_code' => $doc_item_updated->item_code,
            'item_name' => $doc_item_updated->item_name,
            'quantity' => $doc_item_updated->quantity,
            'pending_quantity' => $doc_item_updated->quantity,
            'unit_price' => $doc_item_updated->unit_price,
        ]);
    }

    // *** doc_item.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_doc_item()
    {
        $doc_item1 = factory(DocItem::class)->create();

        $this->json('DELETE', route('api.doc_item.destroy', $doc_item1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_doc_item()
    {
        $this->signIn();

        $doc_item1 = factory(DocItem::class)->create();

        $this->json('DELETE', route('api.doc_item.destroy', $doc_item1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_doc_item()
    {
        $this->signInWithPermission('docs.delete');

        $doc_item1 = factory(DocItem::class)->create();

        $this->json('DELETE', route('api.doc_item.destroy', $doc_item1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('doc_item', [
            'id' => $doc_item1->id,
        ]);
    }
}
