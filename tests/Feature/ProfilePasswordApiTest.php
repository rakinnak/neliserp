<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use Hash;

class ProfilePasswordApiTest extends TestCase
{
    use RefreshDatabase;

    // *** profiles.password_update ***

    /** @test */
    public function guest_user_cannot_update_a_profile_password()
    {
        $this->json('PATCH', route('api.profiles.password_update'))
            ->assertStatus(401);
    }

    /**  @test */
    public function update_a_profile_password_requires_required_fields()
    {
        $this->signInWithPermission('profiles.update');

        $this->json('PATCH', route('api.profiles.password_update'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'old_password' => [
                        'The old password field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_profile_password_requires_password_confirmation_the_same()
    {
        $this->signInWithPermission('profiles.update');

        $this->json('PATCH', route('api.profiles.password_update'), [
            'old_password' => 'old one',
            'password' => 'new password',
            'password_confirmation' => 'not the same',
        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'The password confirmation does not match.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_profile_password_requires_minimum_length_new_password()
    {
        $this->signInWithPermission('profiles.update');

        // password confirmation
        $this->json('PATCH', route('api.profiles.password_update'), [
            'old_password' => 'old one',
            'password' => '12345',
            'password_confirmation' => '12345',
        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'The password must be at least 6 characters.'
                    ],
                ],
            ]);
    }

    /**  @test */
    public function update_a_profile_password_requires_valid_old_password()
    {
        $this->signInWithPermission('profiles.update');

        $user = auth()->user();

        $user->password = Hash::make('old one');
        $user->save();

        // password confirmation
        $this->json('PATCH', route('api.profiles.password_update'), [
            'old_password' => 'invalid',
            'password' => '123456',
            'password_confirmation' => '123456',
        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'old_password' => [
                        'The old password is invalid.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function user_can_update_own_profile_password()
    {
        $this->signInWithPermission('profiles.update');

        $user = auth()->user();
        $user->password = Hash::make('old one');
        $user->save();

        $this->json('PATCH', route('api.profiles.password_update'),
            [
                'old_password' => 'old one',
                'password' => 'new one',
                'password_confirmation' => 'new one',
            ])
            ->assertStatus(200);

        $user_db = User::find($user->id);

        $this->assertTrue(Hash::check('new one', $user_db->password));
    }
}
