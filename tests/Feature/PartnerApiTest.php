<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Company;
use App\Person;
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
        $this->subject = 'company';  // company, person
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

    /** @test */
    public function authorized_user_can_index_partners_only_specified_role()
    {
        $this->signInWithPermission('partners.index');

        $partner1 = $this->create('customer', $this->subject);

        $partner2 = $this->create('supplier', $this->subject);

        $user = auth()->user();

        $this->json('GET', route('api.partners.index', ['supplier']))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $partner2->uuid,
                        'code' => $partner2->code,
                        'name' => $partner2->name,
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'uuid' => $partner1->uuid,
                        'code' => $partner1->code,
                        'name' => $partner1->name,
                    ]
                ]
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

        $this->json('POST', route('api.partners.store', $this->role),
            [
                'subject' => 'company',
                'code' => $partner1->code,
                'name' => $partner1->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function create_a_partner_requires_required_fields()
    {
        $this->signInWithPermission('partners.create');

        $this->json('POST', route('api.partners.store', $this->role))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'subject' => [
                        'The subject field is required.'
                    ],
                    'code' => [
                        'The code field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function create_a_partner_company_requires_required_fields()
    {
        $this->signInWithPermission('partners.create');

        $this->json('POST', route('api.partners.store', $this->role), [
                'subject' => 'company'
            ])
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

    /**  @test */
    public function create_a_partner_person_requires_required_fields()
    {
        $this->signInWithPermission('partners.create');

        $this->json('POST', route('api.partners.store', $this->role), [
                'subject' => 'person'
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_create_a_partner_company()
    {
        $this->signInWithPermission('partners.create');

        $partner1 = factory(Partner::class)->make();

        $this->json('POST', route('api.partners.store', $this->role),
            [
                'subject' => 'company',
                'code' => $partner1->code,
                'name' => $partner1->name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('partners', [
            'subject_type' => 'App\Company',
            'code' => $partner1->code,
            'name' => $partner1->name,
        ]);
    }

    /** @test */
    public function authorized_user_can_create_a_partner_person()
    {
        $this->signInWithPermission('partners.create');

        $person1 = factory(Person::class)->make();

        $partner1 = factory(Partner::class)->make();

        $this->json('POST', route('api.partners.store', $this->role),
            [
                'subject' => 'person',
                'code' => $partner1->code,
                'first_name' => $person1->first_name,
                'last_name' => $person1->last_name,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('partners', [
            'subject_type' => 'App\Person',
            'code' => $partner1->code,
            'name' => "{$person1->first_name} {$person1->last_name}",
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
                'subject' => 'company',
                'code' => $partner_updated->code,
                'name' => $partner_updated->name,
            ])
            ->assertStatus(403);
    }

    /**  @test */
    public function update_a_partner_requires_required_fields()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'subject' => [
                        'The subject field is required.'
                    ],
                    'code' => [
                        'The code field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_partner_company_requires_required_fields()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]), [
                'subject' => 'company',
            ])
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

    /**  @test */
    public function update_a_partner_person_requires_required_fields()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]), [
                'subject' => 'person',
            ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'The code field is required.'
                    ],
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function authorized_user_can_update_a_partner_company()
    {
        $this->signInWithPermission('partners.update');

        $partner1 = $this->create($this->role, $this->subject);

        $partner_updated = factory(Partner::class)->make();

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]),
            [
                'subject' => 'company',
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

    /** @test */
    public function authorized_user_can_update_a_partner_person()
    {
        $this->signInWithPermission('partners.update');

        $this->subject = 'person';

        $partner1 = $this->create($this->role, $this->subject);

        $person1_updated = factory(Person::class)->make();

        $this->json('PATCH', route('api.partners.update', [$this->role, $partner1->uuid]),
            [
                'subject' => 'person',
                'code' => $person1_updated->code,
                'first_name' => $person1_updated->first_name,
                'last_name' => $person1_updated->last_name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('partners', [
            'id' => $partner1->id,
            'uuid' => $partner1->uuid,
            'code' => $person1_updated->code,
            'name' => "{$person1_updated->first_name} {$person1_updated->last_name}",
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
        return factory(Partner::class)->states($role, $subject)->create();

        switch ($subject) {
            case 'company':
                $company1 = factory(Company::class)->create();
                
                return factory(Partner::class)->create([
                    'subject_type' => 'App\Company',
                    'subject_id' => $company1->id,
                    'subject_uuid' => $company1->uuid,
                    'code' => $company1->code,
                    'name' => $company1->name,
                    'is_customer' => $role == 'customer',
                    'is_supplier' => $role == 'supplier',
                ]);
                break;

            case 'person':
                $person1 = factory(Person::class)->create();
                
                return factory(Partner::class)->create([
                    'subject_type' => 'App\Person',
                    'subject_id' => $person1->id,
                    'subject_uuid' => $person1->uuid,
                    'code' => $person1->code,
                    'name' => "{$person1->first_name} {$person1->first_name}",
                    'is_customer' => $role == 'customer',
                    'is_supplier' => $role == 'supplier',
                ]);
                break;
        }
    }
}
