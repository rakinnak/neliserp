<?php

namespace App\Http\Controllers;

use App\Person;

class PersonController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Person::class);

        return view('persons.index');
    }

    public function create()
    {
        //$this->authorize('create', Person::class);

        return view('persons.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $person);

        return view('persons.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $person);

        return view('persons.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $person);

        return view('persons.delete', compact('uuid'));
    }
}
