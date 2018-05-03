<?php

namespace App\Http\Controllers;

use App\Doc;
use App\DocItem;

class DocItemController extends Controller
{
    public function index($type)
    {
        //$this->authorize('index', Doc::class);

        return view('doc_items.index', compact('type'));
    }
}
