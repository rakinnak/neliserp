<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfileAccountRequest;
use App\Http\Resources\UserResource;

class ProfileApi extends ApiController
{
    public function account_show()
    {
        //$this->authorize('show', $profile);

        // auth()->user() returns wasRecentlyCreated: true
        // User::first()  returns wasRecentlyCreated: false

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
}
