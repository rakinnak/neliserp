<?php

namespace App\Http\Controllers;

use App\Doc;

class DocController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Doc::class);

        return view('docs.index');
    }
}
