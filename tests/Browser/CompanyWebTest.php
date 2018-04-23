<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Company;
use App\User;

class CompanyWebTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_index_companies()
    {
        $this->signInWithPermission('companies.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->create();
            $company2 = factory(Company::class)->create();

            $browser->visit('/companies')
                ->waitForText($company1->code)
                ->assertSee($company1->code)
                ->assertSee($company1->name)
                ->assertSee($company2->code)
                ->assertSee($company2->name);
        });
    }

    /** @test */
    public function authorized_user_can_filter_companies_by_company_code_or_name()
    {
        $this->signInWithPermission('companies.index');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company_a1 = factory(Company::class)->create(['code' => 'a-001', 'name' => 'c-001']);
            $company_a2 = factory(Company::class)->create(['code' => 'a-002', 'name' => 'c-002']);
            $company_b1 = factory(Company::class)->create(['code' => 'b-001', 'name' => 'c-003']);
            $company_b2 = factory(Company::class)->create(['code' => 'b-002', 'name' => 'a-004']);

            $browser->visit('/companies?q=a')
                ->waitForText($company_a1->code)
                ->assertSee($company_a1->code)
                ->assertSee($company_a1->name)
                ->assertSee($company_a2->code)
                ->assertSee($company_a2->name)
                ->assertSee($company_b2->code)
                ->assertSee($company_b2->name)
                ->assertDontSee($company_b1->code)
                ->assertDontSee($company_b1->name);
        });
    }

    /** @test */
    public function authorized_user_can_view_an_company()
    {
        $this->signInWithPermission('companies.show');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->create();

            $browser->visit('/companies/' . $company1->uuid)
                ->assertValue('#code', $company1->code)
                ->assertValue('#name', $company1->name);
        });
    }

    /** @test */
    public function create_an_company_requires_valid_fields()
    {
        $this->signInWithPermission('companies.create');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->make();

            $browser->visit('/companies/create')
                ->press('#submit')
                ->assertPathIs('/companies/create')
                ->assertSee('The code field is required')
                ->assertSee('The name field is required');
        });
    }

    /** @test */
    public function authorized_user_can_create_an_company()
    {
        $this->signInWithPermission('companies.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->make();

            $browser->visit('/companies/create')
                ->type('#code', $company1->code . '1')
                ->type('#name', $company1->name . '1')
                ->press('#submit')
                ->waitForText($company1->code)
                ->assertSee($company1->code)
                ->assertPathIs('/companies');
        });
    }

    /** @test */
    public function authorized_user_can_edit_an_company()
    {
        $this->signInWithPermission('companies.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->create();

            $browser->visit('/companies/' . $company1->uuid . '/edit')
                ->type('#code', $company1->code . '-edited')
                ->type('#name', $company1->name . '-edited')
                ->press('#submit')
                ->waitForText('show')
                ->assertValue('#code', $company1->code . '-edited')
                ->assertValue('#name', $company1->name . '-edited')
                ->assertPathIs('/companies/' . $company1->uuid);
        });
    }

    /** @test */
    public function authorized_user_can_delete_an_company()
    {
        $this->signInWithPermission('companies.all');

        $user = auth()->user();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);

            $company1 = factory(Company::class)->create();

            $browser->visit('/companies/' . $company1->uuid . '/delete')
                ->press('#submit')
                ->waitForText('index')
                ->assertDontSee($company1->code)
                ->assertDontSee($company1->name)
                ->assertPathIs('/companies');
        });
    }
}
