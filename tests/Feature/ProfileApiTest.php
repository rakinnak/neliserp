<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class ProfileApiTest extends TestCase
{
    use RefreshDatabase;

    // *** profiles.account_show ***

    /** @test */
    public function guest_user_cannot_view_a_profile_account()
    {
        $this->json('GET', route('api.profiles.account_show'))
            ->assertStatus(401);
    }

    /** @test */
    public function user_can_view_own_profile_account()
    {
        $this->signInWithPermission('profiles.show');

        $user = auth()->user();

        $this->json('GET', route('api.profiles.account_show'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                ],
            ]);
    }

    // *** profiles.account_update ***

    /** @test */
    public function guest_user_cannot_update_a_profile_account()
    {
        $this->json('PATCH', route('api.profiles.account_update'))
            ->assertStatus(401);
    }

    /**  @test */
    public function update_a_profile_account_requires_required_fields()
    {
        $this->signInWithPermission('profiles.update');

        $this->json('PATCH', route('api.profiles.account_update'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_profile_account_requires_valid_fields()
    {
        $this->signInWithPermission('profiles.update');

        $this->json('PATCH', route('api.profiles.account_update'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function user_can_update_own_profile_account()
    {
        $this->signInWithPermission('profiles.update');

        $user = auth()->user();

        $user_updated = factory(User::class)->make();

        $this->json('PATCH', route('api.profiles.account_update'),
            [
                'name' => $user_updated->name,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'name' => $user_updated->name,
        ]);
    }
}
