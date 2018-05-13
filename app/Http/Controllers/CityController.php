<?php

namespace App\Http\Controllers;

use App\City;

class CityController extends Controller
{
    public function index()
    {
        //$this->authorize('index', City::class);

        return view('cities.index');
    }

    public function create()
    {
        //$this->authorize('create', City::class);

        return view('cities.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $city);

        return view('cities.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $city);

        return view('cities.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $city);

        return view('cities.delete', compact('uuid'));
    }
}
