<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Company;
use App\Partner;

class PartnerApiTest extends TestCase
{
    use RefreshDatabase;

    protected $role;
    protected $subject;

    public function setUp()
    {
        parent::setUp();

        $this->role = 'customer';   // customer, supplier
        $this->subject = 'copany';  // company, person
    }

    // *** partners.index ***

    /** @test */
    public function guest_user_cannot_index_partners()
    {
        $this->json('GET', route('api.partners.index', [$this->role]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_index_partners()
    {
        $this->signIn();

        $this->json('GET', route('api.partners.index', [$this->role]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_index_partners()
    {
        $this->signInWithPermission('partners.index');

        $partner1 = $this->create($this->role, $this->subject);

        $partner2 = $this->create($this->role, $this->subject);

        $user = auth()->user();

        $this->json('GET', route('api.partners.index', [$this->role]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $partner1->uuid,
                        'code' => $partner1->code,
                        'name' => $partner1->name,
                    ],
                    [
                        'uuid' => $partner2->uuid,
                        'code' => $partner2->code,
                        'name' => $partner2->name,
                    ]
                ],
                'links' => [
                    'first' => 'http://localhost/api/partners/' . $this->role . '?page=1',
                    'last' => 'http://localhost/api/partners/' . $this->role . '?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/partners/' . $this->role,
                    'per_page' => 10,
                    'to' => 2,
                    'total' => 2
                ],
            ]);
    }

//    /** @test */
//    public function authorized_user_can_filter_partners_by_code()
//    {
//        $this->signInWithPermission('partners.index');
//
//        $partner_a1 = factory(Partner::class)->create(['code' => 'a-001']);
//        $partner_a2 = factory(Partner::class)->create(['code' => 'a-002']);
//        $partner_b1 = factory(Partner::class)->create(['code' => 'b-001']);
//
//        $this->json('GET', route('api.partners.index', [$this->role]) . '?code=a-00')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $partner_a1->uuid,
//                        'code' => $partner_a1->code,
//                        'name' => $partner_a1->name,
//                    ],
//                    [
//                        'uuid' => $partner_a2->uuid,
//                        'code' => $partner_a2->code,
//                        'name' => $partner_a2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $partner_b1->uuid,
//                        'code' => $partner_b1->code,
//                        'name' => $partner_b1->name,
//                    ]
//                ]
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_filter_partners_by_name()
//    {
//        $this->signInWithPermission('partners.index');
//
//        $partner_a1 = factory(Partner::class)->create(['name' => 'a-001']);
//        $partner_a2 = factory(Partner::class)->create(['name' => 'a-002']);
//        $partner_b1 = factory(Partner::class)->create(['name' => 'b-001']);
//
//        $this->json('GET', route('api.partners.index') . '?name=a-00')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $partner_a1->uuid,
//                        'code' => $partner_a1->code,
//                        'name' => $partner_a1->name,
//                    ],
//                    [
//                        'uuid' => $partner_a2->uuid,
//                        'code' => $partner_a2->code,
//                        'name' => $partner_a2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $partner_b1->uuid,
//                        'code' => $partner_b1->code,
//                        'name' => $partner_b1->name,
//                    ]
//                ]
//            ]);
//    }
//
//    /** @test */
//    public function authorized_user_can_filter_partners_by_code_or_name()
//    {
//        $this->signInWithPermission('partners.index');
//
//        $partner_a1 = factory(Partner::class)->create(['code' => 'a-001', 'name' => 'c-001']);
//        $partner_a2 = factory(Partner::class)->create(['code' => 'a-002', 'name' => 'c-002']);
//        $partner_b1 = factory(Partner::class)->create(['code' => 'b-001', 'name' => 'c-003']);
//        $partner_b2 = factory(Partner::class)->create(['code' => 'b-002', 'name' => 'a-004']);
//
//        $this->json('GET', route('api.partners.index') . '?q=a')
//            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    [
//                        'uuid' => $partner_a1->uuid,
//                        'code' => $partner_a1->code,
//                        'name' => $partner_a1->name,
//                    ],
//                    [
//                        'uuid' => $partner_a2->uuid,
//                        'code' => $partner_a2->code,
//                        'name' => $partner_a2->name,
//                    ],
//                    [
//                        'uuid' => $partner_b2->uuid,
//                        'code' => $partner_b2->code,
//                        'name' => $partner_b2->name,
//                    ],
//                ]
//            ])
//            ->assertJsonMissing([
//                'data' => [
//                    [
//                        'uuid' => $partner_b1->uuid,
//                        'code' => $partner_b1->code,
//                        'name' => $partner_b1->name,
//                    ]
//                ]
//            ]);
//    }

    // *** partners.show ***

    /** @test */
    public function guest_user_cannot_view_a_partner()
    {
        $partner1 = $this->create($this->role, $this->subject);

        $this->json('GET', route('api.partners.show', [$this->role, $partner1->uuid]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_view_a_partner()
    {
        $this->signIn();

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('GET', route('api.partners.show', [$this->role, $partner1->uuid]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_a_partner()
    {
        $this->signInWithPermission('partners.show');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('GET', route('api.partners.show', [$this->role, $partner1->uuid]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $partner1->uuid,
                    'code' => $partner1->code,
                    'name' => $partner1->name,
                ],
            ]);
    }

    // *** partners.store ***

    /** @test */
    public function guest_user_cannot_create_a_partner()
    {
        $partner1 = factory(Partner::class)->make();

        $this->json('POST', route('api.partners.store', $this->role), $partner1->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_create_a_partner()
    {
        $this->signIn();

        $partner1 = factory(Partner::class)->make();

        $this->json('POST', route('api.partners.store', $this->role), $partner1->toArray())
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_partner_requires_valid_fields()
    {
        $this->signInWithPermission('partners.create');

        $this->json('POST', route('api.partners.store', $this->role))
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
    public function authorized_user_can_create_a_partner()
    {
        $this->signInWithPermission('partners.create');

        $partner1 = factory(Partner::class)->make();

        $this->json('POST', route('api.partners.store', $this->role),
            [
                'code' => $partner1->code,
                'name' => $partner1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('partners', [
            'code' => $partner1->code,
            'name' => $partner1->name,
        ]);
    }

    // *** partners.update ***

    /** @test */
    public function guest_user_cannot_update_a_partner()
    {
        $partner1 = $this->create($this->role, $this->subject);

        $partner_updated = factory(Partner::class)->make();

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]),
            [
                'code' => $partner_updated->code,
                'name' => $partner_updated->name,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_update_a_partner()
    {
        $this->signIn();

        $partner1 = $this->create($this->role, $this->subject);

        $partner_updated = factory(Partner::class)->make();

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]),
            [
                'code' => $partner_updated->code,
                'name' => $partner_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_partner_requires_valid_fields()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]))
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
    public function authorized_user_can_update_a_partner()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $partner_updated = factory(Partner::class)->make();

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]),
            [
                'code' => $partner_updated->code,
                'name' => $partner_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('partners', [
            'id' => $partner1->id,
            'uuid' => $partner1->uuid,
            'code' => $partner_updated->code,
            'name' => $partner_updated->name,
        ]);
    }

    // *** partners.delete ***

    /** @test */
    public function guest_user_cannot_delete_a_partner()
    {
        $partner1 = $this->create($this->role, $this->subject);

        $this->json('DELETE', route('api.partners.destroy', [$this->role, $partner1->uuid]))
            ->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_denied_to_delete_a_partner()
    {
        $this->signIn();

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('DELETE', route('api.partners.destroy', [$this->role, $partner1->uuid]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_partner()
    {
        $this->signInWithPermission('partners.delete');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('DELETE', route('api.partners.destroy', [$this->role, $partner1->uuid]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('partners', [
            'id' => $partner1->id,
        ]);
    }

    protected function create($role, $subject)
    {
        $company1 = factory(Company::class)->create();
        
        return factory(Partner::class)->create([
            'subject_id' => $company1->id,
            'subject_uuid' => $company1->uuid,
            'code' => $company1->code,
            'name' => $company1->name,
            'is_customer' => $this->role == 'customer',
            'is_supplier' => $this->role == 'supplier',
        ]);
    }

}
