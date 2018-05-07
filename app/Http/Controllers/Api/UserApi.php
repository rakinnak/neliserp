<?php

namespace App\Http\Controllers\Api;

use App\Filters\UserFilter;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class UserApi extends ApiController
{
    public function index(UserFilter $filter)
    {
        $this->authorize('index', User::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $users = User::filter($filter)
            ->paginate($per_page); // TODO: per page configuration

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        $this->authorize('show', $user);

        return new UserResource($user);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $created = User::create([
            'username' => $request['username'],
            'name' => $request['name'],
            'password' => bcrypt(str_random(10)),
            'api_token' => str_random(60),
        ]);

        return $created;
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->username = request('username');
        $user->name = request('name');

        $user->save();

        return $user;
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
    }
}
