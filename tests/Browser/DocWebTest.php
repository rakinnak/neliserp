<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Doc;
use App\User;

class DocWebTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_index_docs()
    {
        $this->signInWithPermission('docs.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->create();
            $doc2 = factory(Doc::class)->create();

            $browser->visit('/docs')
                ->waitForText($doc1->code)
                ->assertSee($doc1->code)
                ->assertSee($doc1->name)
                ->assertSee($doc2->code)
                ->assertSee($doc2->name);
        });
    }

    /** @test */
    public function authorized_user_can_filter_docs_by_doc_code_or_name()
    {
        $this->signInWithPermission('docs.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc_a1 = factory(Doc::class)->create(['code' => 'a-001', 'name' => 'c-001']);
            $doc_a2 = factory(Doc::class)->create(['code' => 'a-002', 'name' => 'c-002']);
            $doc_b1 = factory(Doc::class)->create(['code' => 'b-001', 'name' => 'c-003']);
            $doc_b2 = factory(Doc::class)->create(['code' => 'b-002', 'name' => 'a-004']);

            $browser->visit('/docs?q=a')
                ->waitForText($doc_a1->code)
                ->assertSee($doc_a1->code)
                ->assertSee($doc_a1->name)
                ->assertSee($doc_a2->code)
                ->assertSee($doc_a2->name)
                ->assertSee($doc_b2->code)
                ->assertSee($doc_b2->name)
                ->assertDontSee($doc_b1->code)
                ->assertDontSee($doc_b1->name);
        });
    }

    /** @test */
    public function authorized_user_can_view_an_doc()
    {
        $this->signInWithPermission('docs.show');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->create();

            $browser->visit('/docs/' . $doc1->uuid)
                ->assertValue('#code', $doc1->code)
                ->assertValue('#name', $doc1->name);
        });
    }

    /** @test */
    public function create_an_doc_requires_valid_fields()
    {
        $this->signInWithPermission('docs.create');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->make();

            $browser->visit('/docs/create')
                ->press('#submit')
                ->assertPathIs('/docs/create')
                ->assertSee('The code field is required')
                ->assertSee('The name field is required');
        });
    }

    /** @test */
    public function authorized_user_can_create_an_doc()
    {
        $this->signInWithPermission('docs.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->make();

            $browser->visit('/docs/create')
                ->type('#code', $doc1->code . '1')
                ->type('#name', $doc1->name . '1')
                ->press('#submit')
                ->waitForText($doc1->code)
                ->assertSee($doc1->code)
                ->assertPathIs('/docs');
        });
    }

    /** @test */
    public function authorized_user_can_edit_an_doc()
    {
        $this->signInWithPermission('docs.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->create();

            $browser->visit('/docs/' . $doc1->uuid . '/edit')
                ->type('#code', $doc1->code . '-edited')
                ->type('#name', $doc1->name . '-edited')
                ->press('#submit')
                ->waitForText('show')
                ->assertValue('#code', $doc1->code . '-edited')
                ->assertValue('#name', $doc1->name . '-edited')
                ->assertPathIs('/docs/' . $doc1->uuid);
        });
    }

    /** @test */
    public function authorized_user_can_delete_an_doc()
    {
        $this->signInWithPermission('docs.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $doc1 = factory(Doc::class)->create();

            $browser->visit('/docs/' . $doc1->uuid . '/delete')
                ->press('#submit')
                ->waitForText('index')
                ->assertDontSee($doc1->code)
                ->assertDontSee($doc1->name)
                ->assertPathIs('/docs');
        });
    }
}
