<?php

namespace App\Http\Controllers;

use App\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Permission::class);

        return view('permissions.index');
    }

    public function create()
    {
        //$this->authorize('create', Permission::class);

        return view('permissions.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $permission);

        return view('permissions.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $permission);

        return view('permissions.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $permission);

        return view('permissions.delete', compact('uuid'));
    }
}
