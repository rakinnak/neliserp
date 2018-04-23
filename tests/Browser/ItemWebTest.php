<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Item;
use App\User;

class ItemWebTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_index_items()
    {
        $this->signInWithPermission('items.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->create();
            $item2 = factory(Item::class)->create();

            $browser->visit('/items')
                ->waitForText($item1->code)
                ->assertSee($item1->code)
                ->assertSee($item1->name)
                ->assertSee($item2->code)
                ->assertSee($item2->name);
        });
    }

    /** @test */
    public function authorized_user_can_filter_items_by_item_code_or_name()
    {
        $this->signInWithPermission('items.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item_a1 = factory(Item::class)->create(['code' => 'a-001', 'name' => 'c-001']);
            $item_a2 = factory(Item::class)->create(['code' => 'a-002', 'name' => 'c-002']);
            $item_b1 = factory(Item::class)->create(['code' => 'b-001', 'name' => 'c-003']);
            $item_b2 = factory(Item::class)->create(['code' => 'b-002', 'name' => 'a-004']);

            $browser->visit('/items?q=a')
                ->waitForText($item_a1->code)
                ->assertSee($item_a1->code)
                ->assertSee($item_a1->name)
                ->assertSee($item_a2->code)
                ->assertSee($item_a2->name)
                ->assertSee($item_b2->code)
                ->assertSee($item_b2->name)
                ->assertDontSee($item_b1->code)
                ->assertDontSee($item_b1->name);
        });
    }

    /** @test */
    public function authorized_user_can_view_an_item()
    {
        $this->signInWithPermission('items.show');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->create();

            $browser->visit('/items/' . $item1->uuid)
                ->assertValue('#code', $item1->code)
                ->assertValue('#name', $item1->name);
        });
    }

    /** @test */
    public function create_an_item_requires_valid_fields()
    {
        $this->signInWithPermission('items.create');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->make();

            $browser->visit('/items/create')
                ->press('#submit')
                ->assertPathIs('/items/create')
                ->assertSee('The code field is required')
                ->assertSee('The name field is required');
        });
    }

    /** @test */
    public function authorized_user_can_create_an_item()
    {
        $this->signInWithPermission('items.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->make();

            $browser->visit('/items/create')
                ->type('#code', $item1->code . '1')
                ->type('#name', $item1->name . '1')
                ->press('#submit')
                ->waitForText($item1->code)
                ->assertSee($item1->code)
                ->assertPathIs('/items');
        });
    }

    /** @test */
    public function authorized_user_can_edit_an_item()
    {
        $this->signInWithPermission('items.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->create();

            $browser->visit('/items/' . $item1->uuid . '/edit')
                ->type('#code', $item1->code . '-edited')
                ->type('#name', $item1->name . '-edited')
                ->press('#submit')
                ->waitForText('show')
                ->assertValue('#code', $item1->code . '-edited')
                ->assertValue('#name', $item1->name . '-edited')
                ->assertPathIs('/items/' . $item1->uuid);
        });
    }

    /** @test */
    public function authorized_user_can_delete_an_item()
    {
        $this->signInWithPermission('items.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $item1 = factory(Item::class)->create();

            $browser->visit('/items/' . $item1->uuid . '/delete')
                ->press('#submit')
                ->waitForText('index')
                ->assertDontSee($item1->code)
                ->assertDontSee($item1->name)
                ->assertPathIs('/items');
        });
    }
}
