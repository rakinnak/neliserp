<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Item;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    // *** items.index ***

    /** @test */
    public function unauthorized_user_cannot_view_items()
    {
        $this->json('GET', route('api.items.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function authorized_user_can_view_items()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();

        $this->json('GET', route('api.items.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $item1->uuid,
                        'code' => $item1->code,
                        'name' => $item1->name,
                    ],
                    [
                        'uuid' => $item2->uuid,
                        'code' => $item2->code,
                        'name' => $item2->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_items_by_code()
    {
        $this->signIn();

        $item_a1 = factory(Item::class)->create(['code' => 'a-001']);
        $item_a2 = factory(Item::class)->create(['code' => 'a-002']);
        $item_b1 = factory(Item::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.items.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $item_a1->uuid,
                        'code' => $item_a1->code,
                        'name' => $item_a1->name,
                    ],
                    [
                        'uuid' => $item_a2->uuid,
                        'code' => $item_a2->code,
                        'name' => $item_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $item_b1->uuid,
                        'code' => $item_b1->code,
                        'name' => $item_b1->name,
                    ]
                ]
            ]);
    }


    /** @test */
    public function authorized_user_can_filter_items_by_name()
    {
        $this->signIn();

        $item_a1 = factory(Item::class)->create(['name' => 'a-001']);
        $item_a2 = factory(Item::class)->create(['name' => 'a-002']);
        $item_b1 = factory(Item::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.items.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $item_a1->uuid,
                        'code' => $item_a1->code,
                        'name' => $item_a1->name,
                    ],
                    [
                        'uuid' => $item_a2->uuid,
                        'code' => $item_a2->code,
                        'name' => $item_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $item_b1->uuid,
                        'code' => $item_b1->code,
                        'name' => $item_b1->name,
                    ]
                ]
            ]);
    }

    // *** items.show ***

    /** @test */
    public function unauthorized_user_cannot_view_an_item()
    {
        $item1 = factory(Item::class)->create();

        $this->json('GET', route('api.items.show', $item1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function authorized_user_can_view_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();

        $this->json('GET', route('api.items.show', $item1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $item1->uuid,
                    'code' => $item1->code,
                    'name' => $item1->name,
                ],
            ]);
    }

    // *** items.store ***

    /** @test */
    public function unauthorized_user_cannot_create_an_item()
    {
        $item1 = factory(Item::class)->make();

        $this->json('POST', route('api.items.store'), $item1->toArray())
            ->assertStatus(401);
    }

    /**  @test */
    public function create_an_item_requires_valid_fields()
    {
        $this->signIn();

        $this->json('POST', route('api.items.store'))
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
    public function authorized_user_can_create_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->make();

        $this->json('POST', route('api.items.store'),
            [
                'code' => $item1->code,
                'name' => $item1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('items', [
            'code' => $item1->code,
            'name' => $item1->name,
        ]);
    }

    // *** items.update ***

    /** @test */
    public function unauthorized_user_cannot_update_an_item()
    {
        $item1 = factory(Item::class)->create();

        $item_updated = factory(Item::class)->make();

        $this->json('PATCH', route('api.items.update', $item1->uuid),
            [
                'code' => $item_updated->code,
                'name' => $item_updated->name,
            ])
            ->assertStatus(401);
    }

    /**  @test */
    public function update_an_item_requires_valid_fields()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();

        $this->json('PATCH', route('api.items.update', $item1->uuid))
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
    public function authorized_user_can_update_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();

        $item_updated = factory(Item::class)->make();

        $this->json('PATCH', route('api.items.update', $item1->uuid),
            [
                'code' => $item_updated->code,
                'name' => $item_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('items', [
            'id' => $item1->id,
            'uuid' => $item1->uuid,
            'code' => $item_updated->code,
            'name' => $item_updated->name,
        ]);
    }

    // *** items.delete ***

    /** @test */
    public function unauthorized_user_cannot_delete_an_item()
    {
        $item1 = factory(Item::class)->create();

        $this->json('DELETE', route('api.items.destroy', $item1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function authorized_user_can_delete_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();

        $this->json('DELETE', route('api.items.destroy', $item1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('items', [
            'id' => $item1->id,
        ]);
    }
}
