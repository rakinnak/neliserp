<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        //$this->authorize('index', User::class);

        return view('users.index');
    }

    public function create()
    {
        //$this->authorize('create', User::class);

        return view('users.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $user);

        return view('users.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $user);

        return view('users.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $user);

        return view('users.delete', compact('uuid'));
    }
}
