<?php

namespace App\Http\Controllers;

use App\Location;

class LocationController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Location::class);

        return view('locations.index');
    }

    public function create()
    {
        //$this->authorize('create', Location::class);

        return view('locations.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $location);

        return view('locations.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $location);

        return view('locations.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $location);

        return view('locations.delete', compact('uuid'));
    }
}
