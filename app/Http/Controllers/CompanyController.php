<?php

namespace App\Http\Controllers;

use App\Company;

class CompanyController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Company::class);

        return view('companies.index');
    }

    public function create()
    {
        //$this->authorize('create', Company::class);

        return view('companies.create');
    }

    public function show($uuid)
    {
        // $this->authorize('show', $company);

        return view('companies.show', compact('uuid'));
    }

    public function edit($uuid)
    {
        // $this->authorize('edit', $company);

        return view('companies.edit', compact('uuid'));
    }

    public function delete($uuid)
    {
        // $this->authorize('edit', $company);

        return view('companies.delete', compact('uuid'));
    }
}
