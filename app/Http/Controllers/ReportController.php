<?php

namespace App\Http\Controllers;

//use App\Report;

class ReportController extends Controller
{
    public function index()
    {
        //$this->authorize('index', Report::class);

        return view('reports.index');
    }
}
