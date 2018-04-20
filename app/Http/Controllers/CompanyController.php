<?php

namespace App\Http\Controllers;

use App\Item;

class CompanyController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Company::class);

        return view('companies.index');
    }
}
