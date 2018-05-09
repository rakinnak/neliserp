<?php

namespace App\Http\Controllers\Api;

use Hash;

use App\Activity;
use App\Person;
use App\User;
use App\Http\Requests\ProfileAccountRequest;
use App\Http\Requests\ProfilePasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\ActivityResource;

class ProfileApi extends ApiController
{
    // *** profiles.account
    public function account_show()
    {
        //$this->authorize('show', $profile);

        $user = User::find(auth()->user()->id);

        return new UserResource($user);
    }

    public function account_update(ProfileAccountRequest $request)
    {
        //$this->authorize('update', $profile);

        $user = User::find(auth()->user()->id);
        $user->name = request('name');
        $user->save();

        $person = Person::find($user->person_id);
        $person->first_name = request('first_name');
        $person->last_name = request('last_name');
        $person->save();

        return $user;
    }

    // *** profiles.password
    public function password_update(ProfilePasswordRequest $request)
    {
        //$this->authorize('update', $profile);

        // TODO: update api_token

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request['password']);
        $user->save();

        return $user;
    }

    // *** profiles.activities
    public function activities_show()
    {
        //$this->authorize('show', $profile);

        $user = auth()->user();

        // TODO: should be $user->activities
        $activities = Activity::where('user_id', $user->id)
            ->get();

        return ActivityResource::collection($activities);
    }

}

// Note:
// auth()->user() returns wasRecentlyCreated: true
// User::first()  returns wasRecentlyCreated: false
