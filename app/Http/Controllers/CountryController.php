<?php

namespace App\Http\Controllers;

use App\Country;

class CountryController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Country::class);

        return view('countries.index');
    }

    public function create()
    {
        //$this->authorize('create', Country::class);

        return view('countries.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $country);

        return view('countries.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $country);

        return view('countries.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $country);

        return view('countries.delete', compact('uuid'));
    }
}
