<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Item;

use Illuminate\Support\Str;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_view_items()
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
    public function guest_cannot_view_an_item()
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
                'uuid' => $item1->uuid,
                'code' => $item1->code,
                'name' => $item1->name,
            ]);
    }

    /** @test */
    public function guest_cannot_create_an_item()
    {
        $item1 = factory(Item::class)->make();

        $this->json('POST', route('api.items.store'), $item1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function authorized_user_can_create_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->make();

        $this->json('POST', route('api.items.store'), $item1->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('items', [
            'uuid' => $item1->uuid,
            'code' => $item1->code,
            'name' => $item1->name,
        ]);
    }

    /** @test */
    public function guest_cannot_update_an_item()
    {
        $item1 = factory(Item::class)->create();

        $item_updated = factory(Item::class)->make();

        $this->json('PATCH', route('api.items.update', $item1->uuid), $item_updated->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function authorized_user_can_update_an_item()
    {
        $this->signIn();

        $item1 = factory(Item::class)->create();

        $item_updated = factory(Item::class)->make();

        $this->json('PATCH', route('api.items.update', $item1->uuid), $item_updated->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('items', [
            'id' => $item1->id,
            'uuid' => $item1->uuid,
            'code' => $item_updated->code,
            'name' => $item_updated->name,
        ]);
    }

    /** @test */
    public function guest_cannot_delete_an_item()
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
