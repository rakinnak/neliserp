<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Company;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    // *** companies.index ***

    /** @test */
    public function guest_user_cannot_index_companies()
    {
        $this->json('GET', route('api.companies.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_companies()
    {
        $this->signIn();

        $this->json('GET', route('api.companies.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_companies()
    {
        $this->signInWithPermission('companies.index');

        $company1 = factory(Company::class)->create();
        $company2 = factory(Company::class)->create();

        $user = auth()->user();

        $this->json('GET', route('api.companies.index'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $company1->uuid,
                        'code' => $company1->code,
                        'name' => $company1->name,
                    ],
                    [
                        'uuid' => $company2->uuid,
                        'code' => $company2->code,
                        'name' => $company2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/companies?page=1',
                    'last' => 'http://localhost/api/companies?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/companies',
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_companies_by_code()
    {
        $this->signInWithPermission('companies.index');

        $company_a1 = factory(Company::class)->create(['code' => 'a-001']);
        $company_a2 = factory(Company::class)->create(['code' => 'a-002']);
        $company_b1 = factory(Company::class)->create(['code' => 'b-001']);

        $this->json('GET', route('api.companies.index') . '?code=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $company_a1->uuid,
                        'code' => $company_a1->code,
                        'name' => $company_a1->name,
                    ],
                    [
                        'uuid' => $company_a2->uuid,
                        'code' => $company_a2->code,
                        'name' => $company_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $company_b1->uuid,
                        'code' => $company_b1->code,
                        'name' => $company_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_companies_by_name()
    {
        $this->signInWithPermission('companies.index');

        $company_a1 = factory(Company::class)->create(['name' => 'a-001']);
        $company_a2 = factory(Company::class)->create(['name' => 'a-002']);
        $company_b1 = factory(Company::class)->create(['name' => 'b-001']);

        $this->json('GET', route('api.companies.index') . '?name=a-00')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $company_a1->uuid,
                        'code' => $company_a1->code,
                        'name' => $company_a1->name,
                    ],
                    [
                        'uuid' => $company_a2->uuid,
                        'code' => $company_a2->code,
                        'name' => $company_a2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $company_b1->uuid,
                        'code' => $company_b1->code,
                        'name' => $company_b1->name,
                    ]
                ]
            ]);
    }

    /** @test */
    public function authorized_user_can_filter_companies_by_code_or_name()
    {
        $this->signInWithPermission('companies.index');

        $company_a1 = factory(Company::class)->create(['code' => 'a-001', 'name' => 'c-001']);
        $company_a2 = factory(Company::class)->create(['code' => 'a-002', 'name' => 'c-002']);
        $company_b1 = factory(Company::class)->create(['code' => 'b-001', 'name' => 'c-003']);
        $company_b2 = factory(Company::class)->create(['code' => 'b-002', 'name' => 'a-004']);

        $this->json('GET', route('api.companies.index') . '?q=a')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $company_a1->uuid,
                        'code' => $company_a1->code,
                        'name' => $company_a1->name,
                    ],
                    [
                        'uuid' => $company_a2->uuid,
                        'code' => $company_a2->code,
                        'name' => $company_a2->name,
                    ],
                    [
                        'uuid' => $company_b2->uuid,
                        'code' => $company_b2->code,
                        'name' => $company_b2->name,
                    ],
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $company_b1->uuid,
                        'code' => $company_b1->code,
                        'name' => $company_b1->name,
                    ]
                ]
            ]);
    }

    // *** companies.show ***

    /** @test */
    public function guest_user_cannot_view_an_company()
    {
        $company1 = factory(Company::class)->create();

        $this->json('GET', route('api.companies.show', $company1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_an_company()
    {
        $this->signIn();

        $company1 = factory(Company::class)->create();

        $this->json('GET', route('api.companies.show', $company1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_an_company()
    {
        $this->signInWithPermission('companies.show');

        $company1 = factory(Company::class)->create();

        $this->json('GET', route('api.companies.show', $company1->uuid))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $company1->uuid,
                    'code' => $company1->code,
                    'name' => $company1->name,
                ],
            ]);
    }

    // *** companies.store ***

    /** @test */
    public function guest_user_cannot_create_an_company()
    {
        $company1 = factory(Company::class)->make();

        $this->json('POST', route('api.companies.store'), $company1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_an_company()
    {
        $this->signIn();

        $company1 = factory(Company::class)->make();

        $this->json('POST', route('api.companies.store'), $company1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_an_company_requires_valid_fields()
    {
        $this->signInWithPermission('companies.create');

        $this->json('POST', route('api.companies.store'))
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
    public function authorized_user_can_create_an_company()
    {
        $this->signInWithPermission('companies.create');

        $company1 = factory(Company::class)->make();

        $this->json('POST', route('api.companies.store'),
            [
                'code' => $company1->code,
                'name' => $company1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('companies', [
            'code' => $company1->code,
            'name' => $company1->name,
        ]);
    }

    // *** companies.update ***

    /** @test */
    public function guest_user_cannot_update_an_company()
    {
        $company1 = factory(Company::class)->create();

        $company_updated = factory(Company::class)->make();

        $this->json('PATCH', route('api.companies.update', $company1->uuid),
            [
                'code' => $company_updated->code,
                'name' => $company_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_an_company()
    {
        $this->signIn();

        $company1 = factory(Company::class)->create();

        $company_updated = factory(Company::class)->make();

        $this->json('PATCH', route('api.companies.update', $company1->uuid),
            [
                'code' => $company_updated->code,
                'name' => $company_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_an_company_requires_valid_fields()
    {
        $this->signInWithPermission('companies.update');

        $company1 = factory(Company::class)->create();

        $this->json('PATCH', route('api.companies.update', $company1->uuid))
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
    public function authorized_user_can_update_an_company()
    {
        $this->signInWithPermission('companies.update');

        $company1 = factory(Company::class)->create();

        $company_updated = factory(Company::class)->make();

        $this->json('PATCH', route('api.companies.update', $company1->uuid),
            [
                'code' => $company_updated->code,
                'name' => $company_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'id' => $company1->id,
            'uuid' => $company1->uuid,
            'code' => $company_updated->code,
            'name' => $company_updated->name,
        ]);
    }

    // *** companies.delete ***

    /** @test */
    public function guest_user_cannot_delete_an_company()
    {
        $company1 = factory(Company::class)->create();

        $this->json('DELETE', route('api.companies.destroy', $company1->uuid))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_an_company()
    {
        $this->signIn();

        $company1 = factory(Company::class)->create();

        $this->json('DELETE', route('api.companies.destroy', $company1->uuid))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_an_company()
    {
        $this->signInWithPermission('companies.delete');

        $company1 = factory(Company::class)->create();

        $this->json('DELETE', route('api.companies.destroy', $company1->uuid))
            ->assertStatus(200);

        $this->assertDatabaseMissing('companies', [
            'id' => $company1->id,
        ]);
    }
}
