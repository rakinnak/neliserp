<?php

namespace App\Http\Controllers;

use App\District;

class DistrictController extends Controller
{
    public function index()
    {
        //$this->authorize('index', District::class);

        return view('districts.index');
    }

    public function create()
    {
        //$this->authorize('create', District::class);

        return view('districts.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $district);

        return view('districts.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $district);

        return view('districts.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $district);

        return view('districts.delete', compact('uuid'));
    }
}
