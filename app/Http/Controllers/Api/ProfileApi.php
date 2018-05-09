<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfileAccountRequest;
use App\Http\Requests\ProfilePasswordRequest;
use App\Http\Resources\UserResource;

use Hash;

// Note:
// auth()->user() returns wasRecentlyCreated: true
// User::first()  returns wasRecentlyCreated: false

class ProfileApi extends ApiController
{
    // *** profiles.account
    public function account_show()
    {
        //$this->authorize('show', $profile);

        $user = \App\User::find(auth()->user()->id);

        return new UserResource($user);
    }

    public function account_update(ProfileAccountRequest $request)
    {
        //$this->authorize('update', $profile);

        $user = \App\User::find(auth()->user()->id);
        $user->name = request('name');
        $user->save();

        return $user;
    }

    // *** profiles.password
    public function password_update(ProfilePasswordRequest $request)
    {
        //$this->authorize('update', $profile);

        // TODO: update api_token

        $user = \App\User::find(auth()->user()->id);
        $user->password = Hash::make($request['password']);
        $user->save();

        return $user;
    }
}
