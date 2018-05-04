<?php

namespace App\Http\Controllers;

use App\Partner;

class PartnerController extends Controller
{
    public function index($role)
    {
        //$this->authorize('index', Partner::class);

        return view('partners.index', compact('role'));
    }

    public function create($role)
    {
        //$this->authorize('create', Partner::class);

        return view('partners.create', compact('role'));
    }

    public function show($role, $uuid)
    {
        // $this->authorize('show', $partner);

        return view('partners.show', compact('role', 'uuid'));
    }

    public function edit($role, $uuid)
    {
        // $this->authorize('edit', $partner);

        return view('partners.edit', compact('role', 'uuid'));
    }

    public function delete($role, $uuid)
    {
        // $this->authorize('edit', $partner);

        return view('partners.delete', compact('role', 'uuid'));
    }
}
