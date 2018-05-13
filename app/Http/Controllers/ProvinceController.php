<?php

namespace App\Http\Controllers;

use App\Province;

class ProvinceController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Province::class);

        return view('provinces.index');
    }

    public function create()
    {
        //$this->authorize('create', Province::class);

        return view('provinces.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $province);

        return view('provinces.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $province);

        return view('provinces.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $province);

        return view('provinces.delete', compact('uuid'));
    }
}
