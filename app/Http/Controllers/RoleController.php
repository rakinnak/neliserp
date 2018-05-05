<?php

namespace App\Http\Controllers;

use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Role::class);

        return view('roles.index');
    }

    public function create()
    {
        //$this->authorize('create', Role::class);

        return view('roles.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $role);

        return view('roles.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $role);

        return view('roles.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $role);

        return view('roles.delete', compact('uuid'));
    }
}
