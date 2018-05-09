<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Activity;
use App\Person;
use App\User;

class ProfileActivitiesApiTest extends TestCase
{
    use RefreshDatabase;

    // *** profiles.activities_show ***

    /** @test */
    public function guest_user_cannot_view_a_profile_activities()
    {
        $this->json('GET', route('api.profiles.activities_show'))
            ->assertStatus(401);
    }

    /** @test */
    public function user_can_view_own_profile_activities()
    {
        $this->signInWithPermission('profiles.show');

        $user = auth()->user();

        $activity = factory(Activity::class)->create();

        $this->json('GET', route('api.profiles.activities_show'))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'subject_id' => $activity->subject_id,
                        'subject_type' => $activity->subject_type,
                        'type' => $activity->type,
                        'before' => $activity->before,
                        'after' => $activity->after,
                        //'created_at' => $activity->created_at,    // TODO: how to compare Carbon with Array
                    ]
                ],
            ]);
    }
}



